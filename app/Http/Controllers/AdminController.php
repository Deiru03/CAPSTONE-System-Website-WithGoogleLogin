<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Clearance;
use App\Models\Department;
use App\Models\Program;
/////////////////////////////////////////////// Admin ViewsController ////////////////////////////////////////////////
class AdminController extends Controller
{
    public function dashboard(): View
    {
        //////////////////////// Clearance Counts //////////////////////////
        $TotalUser = User::count();
        $clearancePending = User::where('clearances_status', 'pending')->count();
        $clearanceComplete = User::where('clearances_status', 'complete')->count();
        $clearanceReturn = User::where('clearances_status', 'return')->count();
        $clearanceTotal = $clearancePending + $clearanceComplete + $clearanceReturn;
        $clearanceChecklist = Clearance::count();
        //////////////////////// Faculty Counts //////////////////////////
        $facultyPermanent = User::where('position', 'Permanent')->count();
        $facultyTemporary = User::where('position', 'Temporary')->count();
        $facultyPartTime = User::where('position', 'Part-Timer')->count();
        $facultyAdmin = User::where('user_type', 'Admin')->count();
        $facultyFaculty = User::where('user_type', 'Faculty')->count();

        //////////////////////// College Counts //////////////////////////
        $collegeCount = Department::count();

        if (Auth::check() && Auth::user()->user_type === 'Faculty') {
            return view('dashboard');
        }
        //////////////////////// Dashboard Throw Variables //////////////////////////
        return view('admindashboard', compact('TotalUser', 'clearancePending',
         'clearanceComplete', 'clearanceReturn', 'clearanceTotal',
         'facultyPermanent', 'facultyTemporary', 'facultyPartTime',
         'facultyAdmin', 'facultyFaculty', 'clearanceChecklist', 'collegeCount' ));
    }

    public function clearances(Request $request): View
    {
        $adminId = Auth::id(); // Get the current admin's ID
    
        // Fetch only the users managed by the current admin
        $query = User::whereHas('managingAdmins', function($q) use ($adminId) {
            $q->where('admin_id', $adminId);
        });
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('clearances_status', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }
    
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $query->orderBy('id', $sort);
        }
    
        $clearance = $query->get();
        return view('admin.views.clearances', compact('clearance'));
    }   

    public function submittedReports(): View
    {
        return view ('admin.views.submitted-reports');
    }

    public function faculty(Request $request): View
    {
        $query = User::with(['department', 'program', 'managingAdmins']);
        // Get the currently authenticated admin's name
        $adminName = Auth::user()->name;

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', '%' . $search . '%')
                  ->orWhere('users.email', 'like', '%' . $search . '%')
                  ->orWhere('users.units', 'like', '%' . $search . '%')
                  ->orWhere('users.position', 'like', '%' . $search . '%')
                  ->orWhereHas('department', function($q) use ($search) {
                      $q->where('departments.name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('program', function($q) use ($search) {
                      $q->where('programs.name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('users.name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('users.name', 'desc');
                    break;
                case 'college_asc':
                    $query->join('departments', 'users.department_id', '=', 'departments.id')
                          ->orderBy('departments.name', 'asc')
                          ->select('users.*');
                    break;
                case 'college_desc':
                    $query->join('departments', 'users.department_id', '=', 'departments.id')
                          ->orderBy('departments.name', 'desc')
                          ->select('users.*');
                    break;
                case 'program_asc':
                    $query->join('programs', 'users.program_id', '=', 'programs.id')
                          ->orderBy('programs.name', 'asc')
                          ->select('users.*');
                    break;
                case 'program_desc':
                    $query->join('programs', 'users.program_id', '=', 'programs.id')
                          ->orderBy('programs.name', 'desc')
                          ->select('users.*');
                    break;
                case 'units_asc':
                    $query->orderBy('users.units', 'asc');
                    break;
                case 'units_desc':
                    $query->orderBy('users.units', 'desc');
                    break;
            }
        }

        $faculty = $query->paginate(30);
        $departments = Department::all();
        $programs = Program::all();

        return view('admin.views.faculty', compact('faculty', 'departments', 'programs', 'adminName'));
    }

    public function showCollege(): View
    {
        $departments = Department::with('programs')->get();
        $programs = Program::all();
        $faculty = User::all();

        return view('admin.views.college', compact('departments', 'programs', 'faculty'));
    }

    public function myFiles(): View
    {
        return view ('admin.views.my-files');
    }

    public function profileEdit(): View
    {
        $user = Auth::user();
        $departments = Department::with('programs')->get();
        return view ('admin.profile.edit', compact('user', 'departments'));
    }
    /////////////////////////////////////////////// End of Views Controller ////////////////////////////////////////////////


    /////////////////////////////////////////////// Departments and Programs Controller /////////////////////////////////////////////////
    public function destroyCollegeProgram($id)
    {
        try {
            $program = Program::findOrFail($id);
            $program->delete();

            return response()->json(['success' => true, 'message' => 'Program deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting program: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete program.'], 500);
        }
    }

    public function destroyCollegeDepartment($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();

            return response()->json(['success' => true, 'message' => 'Department deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting department: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete department.'], 500);
        }
    }

    /////////////////////////////////////////////// Admin Faculty /////////////////////////////////////////////////
    public function assignFaculty(Request $request)
    {
        $validatedData = $request->validate([
            'admin_id' => 'required|exists:users,id',
            'faculty_ids' => 'array', // Allow empty array
            'faculty_ids.*' => 'exists:users,id',
        ]);
    
        // Clear existing faculty assignments
        DB::table('admin_faculty')->where('admin_id', $validatedData['admin_id'])->delete();
    
        // Insert new faculty assignments if any
        if (!empty($validatedData['faculty_ids'])) {
            foreach ($validatedData['faculty_ids'] as $facultyId) {
                DB::table('admin_faculty')->insert([
                    'admin_id' => $validatedData['admin_id'],
                    'faculty_id' => $facultyId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Faculty members assigned successfully.']);
    }
    
    public function manageFaculty()
    {
        try {
            $allFaculty = User::with(['department', 'program'])
                ->select('id', 'name', 'position', 'profile_picture', 'department_id', 'program_id')
                ->where('user_type', 'Faculty')
                ->get();
            $managedFaculty = DB::table('admin_faculty')
                ->where('admin_id', Auth::id())
                ->pluck('faculty_id')
                ->toArray();
    
            return response()->json([
                'allFaculty' => $allFaculty,
                'managedFaculty' => $managedFaculty,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching faculty data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch faculty data.'], 500);
        }
    }

    /////////////////////////////////////////////// Departments and Programs /////////////////////////////////////////////////
    public function storeCollegeDepartment(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            $data = $request->only('name', 'description');
    
            if ($request->hasFile('profile_picture')) {
                $filePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $data['profile_picture'] = $filePath;
            }
    
            Department::create($data);
    
            return redirect()->route('admin.views.college')->with('success', 'Department added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.views.college')->with('error', 'Failed to add department.');
        }
    }

    
    public function storeCollegeProgram(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);
        
        try {
            Program::create([
                'name' => $request->name,
                'department_id' => $request->department_id,
            ]);
            
            // Use 'success' as the session key
            return redirect()->route('admin.views.college')->with('success', 'Program added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.views.college')->with('error', 'Failed to add program.');
        }
    }
    
    public function storeMultipleCollegePrograms(Request $request): RedirectResponse
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'programs' => 'required|array',
            'programs.*.name' => 'required|string|max:255',
        ]);

        try {
            foreach ($request->programs as $programData) {
                Program::create([
                    'name' => $programData['name'],
                    'department_id' => $request->department_id,
                ]);
            }

            // Use 'success' as the session key
            return redirect()->route('admin.views.college')->with('success', 'Programs added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.views.college')->with('error', 'Failed to add programs.');
        }
    }

    /////////////////////////////////////////////// Edit Faculty /////////////////////////////////////////////////
    public function getFacultyData($id)
    {
        try {
            $facultyMember = User::with(['department', 'program'])->findOrFail($id);
            return response()->json(['success' => true, 'faculty' => $facultyMember]);
        } catch (\Exception $e) {
            Log::error('Error fetching faculty member: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch faculty member.'], 500);
        }
    }

    public function editFaculty(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department_id' => 'required|exists:departments,id',
            'program_id' => 'required|exists:programs,id',
            'units' => 'nullable|integer',
            'position' => 'nullable|string|max:255',
            'user_type' => 'required|string|max:255',
        ]);

        try {
            $facultyMember = User::findOrFail($validatedData['id']);
            $facultyMember->update($validatedData);

            return response()->json(['success' => true, 'message' => 'Faculty member updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Error updating faculty member: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update faculty member.'], 500);
        }
    }

    public function deleteFaculty(Request $request, $id)
    {
        try {
            $facultyMember = User::findOrFail($id);

            // Optional: Prevent deletion of certain users
            // if ($facultyMember->user_type !== 'Faculty') {
            //     return response()->json(['success' => false, 'message' => 'Invalid user type.'], 400);
            // }

            $facultyMember->delete();

            return response()->json(['success' => true, 'message' => 'Faculty member deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting faculty member: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete faculty member.'], 500);
        }
    }
    ///////////////////////////////////////////// Clearance User Update /////////////////////////////////////////////
    public function updateFacultyClearanceUser(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'id' => 'required|exists:users,id',
                'clearances_status' => 'required|in:pending,complete,return',
                'checked_by' => 'required|string|max:255',
                // Note: 'last_clearance_update' is managed server-side
            ]);
            
            // Retrieve the user
            $user = User::findOrFail($validated['id']);
            Log::info('Before setting, last_clearance_update:', [
                'type' => gettype($user->last_clearance_update),
                'value' => $user->last_clearance_update,
            ]);
            // Update clearance status and checked by fields
            $user->clearances_status = $validated['clearances_status'];
            $user->checked_by = $validated['checked_by'];
    
            // Set 'last_clearance_update' to the current timestamp using Carbon
            $user->last_clearance_update = now();
            Log::info('After setting, last_clearance_update:', [
                'type' => gettype($user->last_clearance_update),
                'value' => $user->last_clearance_update,
            ]);
            // Save the changes
            $user->save();
            
            // Log after saving
            Log::info('After saving, last_clearance_update:', [
                'type' => gettype($user->last_clearance_update),
                'value' => $user->last_clearance_update,
            ]);


            // Return a success response with the updated user data
            return response()->json([
                'success' => true,
                'message' => 'Clearance updated successfully.',
                'user' => [
                    'id' => $user->id,
                    'clearances_status' => $user->clearances_status,
                    'checked_by' => $user->checked_by,
                    'last_clearance_update' => $user->last_clearance_update->format('Y-m-d H:i:s'),
                ],
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Clearance Update Error: ' . $e->getMessage());
    
            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update clearance.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
