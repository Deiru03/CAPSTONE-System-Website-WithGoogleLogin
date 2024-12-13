<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Department;
use App\Models\AdminId;
use App\Models\Campus;
use App\Models\ProgramHeadDeanId;
use App\Models\User;
use App\Models\SubProgram;
use App\Models\Program;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $departments = Department::with('programs')->get();
        $programs = Program::all();
        $user = $request->user()->load('subPrograms'); // Load subPrograms relationship
        $campuses = Campus::all();

        // Fetch the user's sub-programs
        $subProgram = SubProgram::where('user_id', $user->id)->first();

        // check if user has no active clearance
        $noActiveClearance = !$user->clearances()->where('is_active', true)->exists();


        return view('profile.edit', [
            'user' => $request->user(),
            'departments' => $departments,
            'campuses' => $campuses,
            'noActiveClearance' => $noActiveClearance,
            'programs' => $programs,
            'subProgram' => $subProgram,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
         // Skip validation for admins without a campus_id
        if (!($user->user_type === 'Admin' && is_null($user->campus_id) ||
              $user->user_type === 'Program-Head' && is_null($user->campus_id) ||
              $user->user_type === 'Dean' && is_null($user->campus_id))) {
            $request->validate([
                'campus_id' => 'required',
                'department_id' => 'required',
                'program_id' => 'required',
            ]);
        }

        $user->fill($request->validated());
        $campuses = Campus::all();

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $user->profile_picture = '/storage/' . $path;
        }

         // Handle ID based on user type
        if (in_array($request->input('user_type'), ['Admin', 'Dean', 'Program-Head'])) {
            // Skip ID validation for superadmin
            if (!($user->user_type === 'Admin' && is_null($user->campus_id) ||
                $user->user_type === 'Program-Head' && is_null($user->campus_id) ||
                $user->user_type === 'Dean' && is_null($user->campus_id))) {
                if ($request->has('admin_id')) {
                    $request->validate([
                        'admin_id' => ['required', 'exists:admin_ids,admin_id'],
                    ], [
                        'admin_id.exists' => 'The provided Admin ID does not exist.',
                    ]);

                    $adminId = AdminId::where('admin_id', $request->admin_id)->first();

                    if ($adminId->is_assigned && $adminId->user_id !== $user->id) {
                        return back()->withErrors(['admin_id' => 'This Admin ID is already assigned to another user.']);
                    }

                    $user->admin_id_registered = $request->admin_id;
                    $adminId->update([
                        'is_assigned' => true,
                        'user_id' => $user->id,
                    ]);
                }

                if ($request->has('program_head_id') || $request->has('dean_id')) {
                    $identifier = $request->input('user_type') === 'Program-Head' ? $request->program_head_id : $request->dean_id;
                    $programHeadDeanId = ProgramHeadDeanId::where('identifier', $identifier)->first();

                    if (!$programHeadDeanId) {
                        return back()->withErrors(['id' => 'The provided ID does not exist.']);
                    }

                    if ($programHeadDeanId->is_assigned && $programHeadDeanId->user_id !== $user->id) {
                        $idType = $request->input('user_type') === 'Program-Head' ? 'Program Head ID' : 'Dean ID';
                        return back()->withErrors(['id' => "This {$idType} is already assigned to another user."]);
                    }

                    if ($programHeadDeanId->type && $programHeadDeanId->type !== $request->input('user_type')) {
                        $idType = $programHeadDeanId->type === 'Program-Head' ? 'Program Head ID' : 'Dean ID';
                        return back()->withErrors(['id' => "This ID is already assigned as a {$idType}."]);
                    }

                    $programHeadDeanId->update([
                        'is_assigned' => true,
                        'user_id' => $user->id,
                        'type' => $request->input('user_type')
                    ]);

                    if ($request->input('user_type') === 'Program-Head') {
                        $user->program_head_id = $request->program_head_id;
                    } else {
                        $user->dean_id = $request->dean_id;
                    }
                }
            }
        } else {
            // Preserve IDs when switching to Faculty
            if ($user->user_type === 'Program-Head') {
                $user->program_head_id = $request->program_head_id;
            } elseif ($user->user_type === 'Dean') {
                $user->dean_id = $request->dean_id;
            }
        }
        // $user->clearances_status = 'pending';
        // $user->checked_by = 'System';
        $program = \App\Models\Program::find($request->input('program_id'));

        $user->position = $request->input('position');
        $user->units = $request->input('units');
        $user->campus_id = $request->input('campus_id');
        $user->department_id = $request->input('department_id');
        $user->program_id = $request->input('program_id');
        $user->program = $program ? $program->name : null;

        $user->save();

        // Save the sub-program
        $subProgramIds = $request->input('sub_program_ids', []);
        SubProgram::where('user_id', $user->id)->delete(); // Clear existing sub-programs

        foreach ($subProgramIds as $programId) {
            SubProgram::create([
                'user_id' => $user->id,
                'program_id' => $programId,
                'sub_program_name' => Program::find($programId)->name,
            ]);
        }


        if ($user->user_type === 'Admin' || $user->user_type === 'Dean' || $user->user_type === 'Program-Head') {
            return Redirect::route('admin.profile.edit')->with('status', 'profile-updated', 'campuses');
        } else {
            return Redirect::route('profile.edit')->with('status', 'profile-updated', 'campuses');
        }
    }

    /**
     * Switch user type
     */
    public function switchRole(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $newRole = $request->input('role');

        $roles = $user->availableRoles();

        if (in_array($newRole, $roles)) {
            $user->switchRole($newRole); // Use the switchRole method from the User model

            return redirect()->back()->with('success', "Switched to {$newRole} successfully.");
        }

        return redirect()->back()->with('error', 'Role switch not allowed.');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
