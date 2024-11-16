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
use App\Models\Program;
use App\Models\Campus;
use App\Models\AdminId;
use App\Models\ProgramHeadDeanId;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $campuses = Campus::all();
        $departments = Department::all();
        $programs = Program::all();
        return view('auth.register', compact('campuses', 'departments'));
    }

    public function getDepartments($campusId)
    {
        $departments = Department::where('campus_id', $campusId)->get();
        return response()->json($departments);
    }

    public function getPrograms($departmentId)
    {
        $programs = Program::where('department_id', $departmentId)->get();
        return response()->json($programs);
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
            'user_type' => ['required', 'string', 'in:Admin,Faculty,Program-Head,Dean'],
            'units' => ['nullable', 'integer'],
            'program' => ['nullable', 'string'],
            'position' => ['required', 'string', 'in:Permanent-FullTime,Permanent-PartTime,Temporary,Part-Timer,Dean,Program-Head'],
            'department_id' => ['required', 'exists:departments,id'],
            'program_id' => ['required', 'exists:programs,id'],
            'campus_id' => ['required', 'exists:campuses,id'],
            'admin_id' => ['required_if:user_type,Admin', 'nullable', 'exists:admin_ids,admin_id'],
            'program_head_id' => ['required_if:user_type,Program-Head', 'nullable', 'exists:program_head_dean_ids,identifier'],
            'dean_id' => ['required_if:user_type,Dean', 'nullable', 'exists:program_head_dean_ids,identifier'],
        ], [
            'admin_id.required_if' => 'The Admin ID is required when registering as an Admin.',
            'admin_id.exists' => 'The provided Admin ID does not exist.',
            'program_head_id.required_if' => 'The Program Head ID is required when registering as a Program Head.',
            'program_head_id.exists' => 'The provided Program Head ID does not exist.',
            'dean_id.required_if' => 'The Dean ID is required when registering as a Dean.',
            'dean_id.exists' => 'The provided Dean ID does not exist.',
        ]);

        // Check Admin ID assignment before creating user
        if ($request->user_type === 'Admin') {
            $adminId = AdminId::where('admin_id', $request->admin_id)->first();
            if (!$adminId) {
                return back()->withErrors(['admin_id' => 'The provided Admin ID does not exist.']);
            }
            if ($adminId->is_assigned) {
                return back()->withErrors(['admin_id' => 'The provided Admin ID is already assigned.']);
            }
        }

        // Check Program Head/Dean ID assignment
        if ($request->user_type === 'Program-Head' || $request->user_type === 'Dean') {
            $identifier = $request->user_type === 'Program-Head' ? $request->program_head_id : $request->dean_id;
            $programHeadDeanId = ProgramHeadDeanId::where('identifier', $identifier)->first();
            
            if (!$programHeadDeanId) {
                $errorField = $request->user_type === 'Program-Head' ? 'program_head_id' : 'dean_id';
                return back()->withErrors([$errorField => "The provided ID does not exist."]);
            }

            if ($programHeadDeanId->is_assigned) {
                $errorField = $request->user_type === 'Program-Head' ? 'program_head_id' : 'dean_id';
                return back()->withErrors([$errorField => 'The provided ID is already assigned to another user.']);
            }

            // Check if type exists and matches user_type
            if ($programHeadDeanId->type && $programHeadDeanId->type !== $request->user_type) {
                $errorField = $request->user_type === 'Program-Head' ? 'program_head_id' : 'dean_id';
                return back()->withErrors([
                    $errorField => "This ID is designated for {$programHeadDeanId->type} role only."
                ]);
            }

            // Assign type if null
            if (!$programHeadDeanId->type) {
                $programHeadDeanId->type = $request->user_type;
                $programHeadDeanId->save();
            }
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
            'campus_id' => $request->campus_id,
            'program' => Program::find($request->program_id)->name,
            'admin_id_registered' => $request->admin_id,
            'program_head_id' => $request->program_head_id,
            'dean_id' => $request->dean_id,
        ]);

        // Handle ID assignments after user creation
        if ($request->user_type === 'Admin') {
            $adminId->update([
                'is_assigned' => true,
                'user_id' => $user->id
            ]);
        } elseif ($request->user_type === 'Program-Head' || $request->user_type === 'Dean') {
            $programHeadDeanId->update([
                'is_assigned' => true,
                'user_id' => $user->id
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('homepage', absolute: false));
    }
}
