<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Department;
use App\Models\AdminId;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $departments = Department::all();
        return view('auth.register', compact('departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed',
                Rules\Password::min(8)
                ->letters()
                ->numbers()
                ->mixedCase()
                ->symbols()],
            'user_type' => ['required', 'string', 'in:Admin,Faculty'],
            'units' => ['nullable', 'integer'],
            'program' => ['nullable', 'string'],
            'position' => ['required', 'string', 'in:Permanent,Temporary,Part-Timer'],
            'department_id' => ['required', 'exists:departments,id'],
            'program_id' => ['required', 'exists:programs,id'],
            'admin_id' => ['required_if:user_type,Admin', 'nullable', 'exists:admin_ids,admin_id'],
        ], [
            'admin_id.required_if' => 'The Admin ID is required when registering as an Admin.',
            'admin_id.exists' => 'The provided Admin ID does not exist.',
        ]);

        if ($request->user_type === 'Admin') {
            $adminId = AdminId::where('admin_id', $request->admin_id)->first();
            if ($adminId->is_assigned) {
                return back()->withErrors(['admin_id' => 'The provided Admin ID is already assigned.']);
            }
            $adminId->is_assigned = true;
            $adminId->save();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'units' => $request->units,
            'position' => $request->position,
            'department_id' => $request->department_id,
            'program_id' => $request->program_id,
            'program' => \App\Models\Program::find($request->program_id)->name,
            'admin_id_registered' => $request->admin_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('homepage', absolute: false));
    }
}
