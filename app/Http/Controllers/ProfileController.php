<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Department;
use App\Models\AdminId;
use App\Models\Campus;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $departments = Department::with('programs')->get();
        $user = $request->user();
        $campuses = Campus::all();

        // check if user has no active clearance
        $noActiveClearance = !$user->clearances()->where('is_active', true)->exists();


        return view('profile.edit', [
            'user' => $request->user(),
            'departments' => $departments,
            'campuses' => $campuses,
            'noActiveClearance' => $noActiveClearance,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
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
    
        // Handle admin_id based on user type
        if ($request->input('user_type') === 'Admin' || $request->input('user_type') === 'Dean' || $request->input('user_type') === 'Program-Head') {
            if ($request->has('admin_id')) {
                $request->validate([
                    'admin_id' => ['required', 'exists:admin_ids,admin_id'],
                ], [
                    'admin_id.exists' => 'The provided Admin ID does not exist.',
                ]);
        
                $adminId = AdminId::where('admin_id', $request->admin_id)->first();
                if ($adminId->is_assigned && $adminId->admin_id !== $user->admin_id_registered) {
                    return back()->withErrors(['admin_id' => 'The provided Admin ID is already assigned.']);
                }
                
                $user->user_type = $request->input('user_type');
                AdminId::where('admin_id', $request->admin_id)->update([
                    'is_assigned' => true,
                    'user_id' => $user->id
                ]);
                $user->admin_id_registered = $request->admin_id;
            }
        } else {
            // If user is Faculty, set admin_id to null and remove user_id from admin_ids
            if ($user->admin_id_registered) {
                AdminId::where('admin_id', $user->admin_id_registered)->update([
                    'is_assigned' => false,
                    'user_id' => null
                ]);
            }
            $user->user_type = 'Faculty';
            $user->admin_id_registered = null;
        }
    
        // $user->clearances_status = 'pending';
        // $user->checked_by = 'System';
        $program = \App\Models\Program::find($request->input('program_id'));

        $user->program = $program ? $program->name : null;
        $user->position = $request->input('position');
        $user->units = $request->input('units');
        $user->campus_id = $request->input('campus_id');
        $user->department_id = $request->input('department_id');
        $user->program_id = $request->input('program_id');
    
        $user->save();
    
        if ($user->user_type === 'Admin' || $user->user_type === 'Dean' || $user->user_type === 'Program-Head') {
            return Redirect::route('admin.profile.edit')->with('status', 'profile-updated', 'campuses');
        } else {
            return Redirect::route('profile.edit')->with('status', 'profile-updated', 'campuses');
        }
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
