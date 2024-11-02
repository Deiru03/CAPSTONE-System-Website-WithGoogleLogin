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
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $departments = Department::with('programs')->get();
        $user = $request->user();

        // check if user has no active clearance
        $noActiveClearance = !$user->clearances()->where('is_active', true)->exists();


        return view('profile.edit', [
            'user' => $request->user(),
            'departments' => $departments,
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
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $user->profile_picture = '/storage/' . $path;
        }
    
        // Handle admin_id for Admin users
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
            AdminId::where('admin_id', $request->admin_id)->update(['is_assigned' => true]);
            $user->admin_id_registered = $request->admin_id;
        }
    
        $user->clearances_status = 'pending';
        $user->checked_by = 'System';
        $program = \App\Models\Program::find($request->input('program_id'));
        
        $user->program = $program ? $program->name : null;
        $user->position = $request->input('position');
        $user->units = $request->input('units');
        $user->department_id = $request->input('department_id');
        $user->program_id = $request->input('program_id');
    
        $user->save();
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
