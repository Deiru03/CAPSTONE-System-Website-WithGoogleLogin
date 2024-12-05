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
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Clearance;
use App\Models\Department;
use App\Models\Program;
use App\Models\SubmittedReport;
use App\Models\UserClearance;
use App\Models\UploadedClearance;
use App\Models\AdminId;
use App\Models\Campus;
use App\Models\ProgramHeadDeanId;
use App\Services\FileDeletionService;
use App\Models\SharedClearance;
use App\Models\SubProgram;
use Carbon\Carbon;
/////////////////////////////////////////////// Admin ViewsController ////////////////////////////////////////////////
class AdminController extends Controller
{
    public function home(): View
    {
        return view('admin.home');
    }

     /////////////////////////////////////////////// Auto Update Clearance Status Controller /////////////////////////////////////////////////

     public function updateClearanceStatus($userId)
     {
         $userClearance = UserClearance::with('sharedClearance.clearance.requirements.feedback')
             ->where('user_id', $userId)
             ->first();

         if ($userClearance) {
             $allSigned = $userClearance->sharedClearance->clearance->requirements->every(function ($requirement) use ($userClearance) {
                 $feedback = $requirement->feedback->where('user_id', $userClearance->user_id)->first();
                 return $feedback && ($feedback->signature_status === 'Complied' || $feedback->signature_status === 'Not Applicable');
             });

             $user = User::find($userId);
             $user->clearances_status = $allSigned ? 'complete' : 'pending';
             $user->last_clearance_update = now(); // Update the last_clearance_update column
             $user->save();
         }
     }

     /////////////////////////////////////////////// End of Auto Update Clearance Status Controller /////////////////////////////////////////////////

    public function dashboard(): View
    {
        $user = Auth::user();

        //////////////////////// Base Query Setup //////////////////////////
        $userQuery = User::query();

        // Apply filters based on user type and scope
        if ($user->user_type === 'Admin' && !$user->campus_id) {
            // Admin with no campus (super admin) can see all
        } elseif ($user->user_type === 'Admin') {
            $userQuery->where('campus_id', $user->campus_id);
        } elseif ($user->user_type === 'Dean') {
            $userQuery->where('department_id', $user->department_id);
        } elseif ($user->user_type === 'Program-Head') {
            $userQuery->where('program_id', $user->program_id)
                      ->orWhereHas('subPrograms', function($sq) use ($user) {
                          $sq->where('program_id', $user->program_id);
                      });
        }

        //////////////////////// Clearance Counts //////////////////////////
        $TotalUser = (clone $userQuery)->count();
        $clearancePending = (clone $userQuery)->where('clearances_status', 'Pending')->count();
        $clearanceComplete = (clone $userQuery)->where('clearances_status', 'Complete')->count();
        $clearanceReturn = (clone $userQuery)->where('clearances_status', 'Return')->count();
        $clearanceTotal = $clearancePending + $clearanceComplete + $clearanceReturn;
        $clearanceChecklist = Clearance::count();

        //////////////////////// Faculty Counts //////////////////////////
        $facultyDean = (clone $userQuery)->where('position', 'Dean')->orWhere('user_type', 'Dean')->count();
        $facultyPH = (clone $userQuery)->where('position', 'Program-Head')->orWhere('user_type', 'Program-Head')->count();
        $facultyPermanentT = (clone $userQuery)->where('position', 'Permanent-Temporary')->count();
        $facultyPermanentFT = (clone $userQuery)->where('position', 'Permanent-FullTime')->count();
        $facultyPartTimeFT = (clone $userQuery)->where('position', 'Part-Time-FullTime')->count();
        $facultyPartTime = (clone $userQuery)->where('position', 'Part-Time')->count();
        $facultyAdmin = (clone $userQuery)->where('user_type', 'Admin')->count();
        $facultyFaculty = (clone $userQuery)->where('user_type', 'Faculty')->count();
        $usersDean = (clone $userQuery)->where('user_type', 'Dean')->count();
        $usersPH = (clone $userQuery)->where('user_type', 'Program-Head')->count();

        //////////////////////// College Counts //////////////////////////
        if ($user->user_type === 'Admin' && !$user->campus_id) {
            $collegeCount = Department::count();
        } elseif ($user->user_type === 'Admin') {
            $collegeCount = Department::where('campus_id', $user->campus_id)->count();
        } elseif ($user->user_type === 'Dean') {
            $collegeCount = Department::where('id', $user->department_id)->count();
        } elseif ($user->user_type === 'Program-Head') {
            $collegeCount = Department::whereHas('programs', function($query) use ($user) {
                $query->where('id', $user->program_id)
                      ->orWhereHas('subPrograms', function($sq) use ($user) {
                          $sq->where('program_id', $user->program_id);
                      });
            })->count();
        }

        //////////////////////// Admin Management Counts //////////////////////////
        $adminManagementCounts = DB::table('admin_faculty')
            ->select('admin_id', DB::raw('count(faculty_id) as managed_count'))
            ->groupBy('admin_id')
            ->get()
            ->mapWithKeys(function ($item) {
                $adminName = User::find($item->admin_id)->name;
                return [$adminName => $item->managed_count];
            });

        //////////////////////// Users Managed by Current Admin //////////////////////////
        $adminId = Auth::id();
        $managedUsers = User::whereHas('managingAdmins', function($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })->get(['id', 'name', 'profile_picture', 'clearances_status', 'email']);

        $managedFacultyCount = $managedUsers->count();

        //////////////////////// Data Analytics //////////////////////////
        $completedClearancesThisMonth = User::where('clearances_status', 'complete')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->count();

        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)->count();

        $recentLogins = User::whereMonth('last_clearance_update', Carbon::now()->month)->count();

        // Start building the query for submitted reports count
        $submittedReportsQuery = SubmittedReport::with('user')
            ->leftJoin('users as faculty', 'submitted_reports.user_id', '=', 'faculty.id');

        // Apply filters based on user type
        if (Auth::check() && Auth::user()->user_type === 'Admin' && !Auth::user()->campus_id) {
            $submittedReportsCount = $submittedReportsQuery->count(); // Count all reports for super admin
        } elseif (Auth::check() && Auth::user()->user_type === 'Admin') {
            $submittedReportsCount = $submittedReportsQuery->whereHas('user', function($q) {
                $q->where('campus_id', Auth::user()->campus_id);
            })->count(); // Count reports for campus admin
        } elseif (Auth::check() && Auth::user()->user_type === 'Dean') {
            $submittedReportsCount = $submittedReportsQuery->whereHas('user', function($q) {
                $q->where('department_id', Auth::user()->department_id);
            })->count(); // Count reports for dean
        } elseif (Auth::check() && Auth::user()->user_type === 'Program-Head') {
            $submittedReportsCount = $submittedReportsQuery->whereHas('user', function($q) {
                $q->where('program_id', Auth::user()->program_id)
                  ->orWhereHas('subPrograms', function($sq) {
                      $sq->where('program_id', Auth::user()->program_id);
                  });
            })->count(); // Count reports for program head
        }

        if (Auth::check() && Auth::user()->user_type === 'Faculty') {
            return view('dashboard');
        }

        //////////////////////// Dashboard Throw Variables //////////////////////////
        return view('admin-dashboard', compact('TotalUser', 'clearancePending',
         'clearanceComplete', 'clearanceReturn', 'clearanceTotal',
         'facultyAdmin', 'facultyFaculty', 'clearanceChecklist', 'collegeCount',
         'managedUsers', 'managedFacultyCount', 'submittedReportsCount',
         'facultyPartTime', 'facultyPartTimeFT', 'facultyPermanentFT', 'facultyPermanentT', 'facultyDean', 'facultyPH',
         'usersDean', 'usersPH',
         'completedClearancesThisMonth', 'newUsersThisMonth', 'recentLogins'));
    }

    public function clearances(Request $request): View
    {
        $user = Auth::user();

        // Start building the query
        $query = User::with(['program', 'department', 'campus', 'uploadedClearances' => function($query) {
            $query->latest(); // Get the most recent uploads
        }]);

        // Apply filters based on user type
        if ($user->user_type === 'Admin' && !$user->campus_id) {
            // Admin with no campus can view all users
        }elseif ($user->user_type === 'Admin') {
            $query->where('campus_id', $user->campus_id);
        } elseif ($user->user_type === 'Dean') {
            $query->where('department_id', $user->department_id);
        } elseif ($user->user_type === 'Program-Head') {
            $query->where('program_id', $user->program_id)
                  ->orWhereHas('subPrograms', function($sq) use ($user) {
                      $sq->where('program_id', $user->program_id);
                  });
        }

        // Handle search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('clearances_status', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('department', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('campus', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Fetch users with their latest clearance activities
        $users = User::with([
            'userClearances.sharedClearance.clearance',
            'uploadedClearances' => function($query) {
                $query->latest()->take(1); // Get only the most recent upload
            }
        ])->get();

        $sharedClearances = SharedClearance::with('clearance')->get();

        // Handle sorting
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'latest_upload') {
                $query->orderBy(
                    UploadedClearance::select('created_at')
                        ->whereColumn('user_id', 'users.id')
                        ->latest()
                        ->limit(1),
                    'desc'
                );
            } else {
                $query->orderBy('id', $sort);
            }
        } else {
            // Default sort by latest upload
            $query->orderBy(
                UploadedClearance::select('created_at')
                    ->whereColumn('user_id', 'users.id')
                    ->latest()
                    ->limit(1),
                'desc'
            );
        }

        $clearances = UserClearance::with([
            'sharedClearance',
            'user.uploadedClearances' => function($query) {
                $query->latest();
            }
        ])->get();

        // Get submitted reports activity for the last 7 days with user type filtering
        $submittedReportsQuery = SubmittedReport::where('created_at', '>=', now()->subDays(6));

        // Apply filters based on user type
        if ($user->user_type === 'Admin' && !$user->campus_id) {
            // Super Admin can see all reports
        } elseif ($user->user_type === 'Admin') {
            // Campus Admin: only see reports from their campus
            $submittedReportsQuery->whereHas('user', function($query) use ($user) {
                $query->where('campus_id', $user->campus_id);
            });
        } elseif ($user->user_type === 'Dean') {
            // Dean: only see reports from their department
            $submittedReportsQuery->whereHas('user', function($query) use ($user) {
                $query->where('department_id', $user->department_id);
            });
        } elseif ($user->user_type === 'Program-Head') {
            // Program Head: only see reports from their program and sub-programs
            $submittedReportsQuery->whereHas('user', function($query) use ($user) {
                $query->where('program_id', $user->program_id)
                      ->orWhereHas('subPrograms', function($sq) use ($user) {
                          $sq->where('program_id', $user->program_id);
                      });
            });
        }

        // Get the filtered activity data
        $submittedReportsActivity = $submittedReportsQuery
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Create arrays for the last 7 days with counts and labels
        $activityData = [];
        $labels = [];

        // Get total counts for the summary
        $totalActivities = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $submittedReportsActivity
                ->where('date', $date)
                ->first()
                ->count ?? 0;

            $activityData[] = $count;
            $labels[] = now()->subDays($i)->format('M d');
            $totalActivities += $count;
        }

        // Get activity breakdown by transaction type
        $activityBreakdown = $submittedReportsQuery
            ->selectRaw('transaction_type, COUNT(*) as count')
            ->groupBy('transaction_type')
            ->get()
            ->pluck('count', 'transaction_type')
            ->toArray();

        $clearance = $query->paginate(100);

        return view('admin.views.clearances', compact(
            'clearance',
            'clearances',
            'users',
            'sharedClearances',
            'activityData',
            'labels',
            'totalActivities',
            'activityBreakdown'
        ));
    }

    public function submittedReports(): View
    {
        // Get the current admin's ID and user type
        $user = Auth::user();

        // Start building the query
        $query = SubmittedReport::with('user')
            ->leftJoin('users as admins', 'submitted_reports.admin_id', '=', 'admins.id')
            ->leftJoin('users as faculty', 'submitted_reports.user_id', '=', 'faculty.id')
            ->select(
                'submitted_reports.*',
                'admins.name as admin_name',
                'faculty.name as faculty_name'
            );

        // Apply filters based on user type
        if ($user->user_type === 'Admin' && !$user->campus_id) {
            $submittedReportsCount = $query->count(); // Count all reports for super admin
        } elseif ($user->user_type === 'Admin') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('campus_id', $user->campus_id);
            });
            $submittedReportsCount = $query->count(); // Count reports for campus admin
        } elseif ($user->user_type === 'Dean') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('department_id', $user->department_id);
            });
            $submittedReportsCount = $query->count(); // Count reports for dean
        } elseif ($user->user_type === 'Program-Head') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('program_id', $user->program_id)
                  ->orWhereHas('subPrograms', function($sq) use ($user) {
                      $sq->where('program_id', $user->program_id);
                  });
            });
            $submittedReportsCount = $query->count(); // Count reports for program head
        }

        // Get the final results
        $reports = $query->orderBy('submitted_reports.created_at', 'desc')->get();

        return view('admin.views.history-reports', compact('reports', 'submittedReportsCount', 'user'));
    }

    public function adminActionReports(): View
    {
        $reports = SubmittedReport::with('user')
        ->leftJoin('users as admins', 'submitted_reports.admin_id', '=', 'admins.id')
        ->select('submitted_reports.*', 'admins.name as admin_name')
        ->whereNotNull('submitted_reports.admin_id')
        ->orderBy('submitted_reports.created_at', 'desc')
        ->get();

        return view('admin.views.admin-action-reports', compact('reports'));
    }

    public function faculty(Request $request): View
    {
        $query = User::with(['department', 'program', 'managingAdmins']);
        // Get the currently authenticated admin's name
        $adminName = Auth::user()->name;
        $user = Auth::user();

        // Filter based on user type
        if ($user->user_type === 'Admin' && !$user->campus_id) {
            // Admin with no campus can view all users
        }elseif ($user->user_type === 'Admin') {
            $query->whereHas('department', function($q) use ($user) {
                $q->where('campus_id', $user->campus_id);
            });
        } elseif ($user->user_type === 'Dean') {
            $query->where('department_id', $user->department_id);
        } elseif ($user->user_type === 'Program-Head') {
            $query->where('program_id', $user->program_id)
                  ->orWhereHas('subPrograms', function($q) use ($user) {
                      $q->where('program_id', $user->program_id);
                  });
        }

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

        $faculty = $query->paginate(100); // Show 100 records per page to handle larger datasets while maintaining performance

        foreach ($faculty as $member) {
            $member->program_name = Program::find($member->program_id)->name ?? 'N/A';
        }

        $departments = Department::all();
        $programs = Program::all();

        return view('admin.views.faculty', compact('faculty', 'departments', 'programs', 'adminName'));
    }

    public function showCollege(): View
    {
        $user = Auth::user();

        // Start with base query for departments only
        $departmentsQuery = Department::with('programs');

        // Apply filters based on user type for departments only
        if ($user->user_type === 'Admin' && !$user->campus_id) {
            // Super admin can see all departments - no filters needed
        } elseif ($user->user_type === 'Admin') {
            // Campus admin - filter departments by campus_id
            $departmentsQuery->where('campus_id', $user->campus_id);
        }

        // Get the filtered departments and all programs/users
        $departments = $departmentsQuery->get();
        $programs = Program::all(); // Get all programs
        $faculty = User::all(); // Get all users
        $users = User::all(); // Get all users

        return view('admin.views.college', compact('departments', 'programs', 'faculty', 'users'));
    }

    public function editDepartment($id): View
    {
        $department = Department::with('programs.users')->findOrFail($id);
        $department1 = Department::with('programs.users')->findOrFail($id);
        $departments = Department::with('programs')->get();

        $users = User::all();

        $programs = Program::where('department_id', $id)->get();
        $campuses = Campus::all(); // Fetch all campuses

        return view('admin.views.colleges.edit-department', compact('department', 'programs', 'departments','department1', 'users', 'campuses'));
    }

    public function myFiles(): View
    {
        return view ('admin.views.my-files');
    }

    public function archive(Request $request): View
    {
        try {
            $search = $request->get('search', '');

            // Fetch all archived clearances with search functionality
            $archivedClearances = UploadedClearance::where('is_archived', true)
                ->where('file_path', 'like', "%{$search}%") // Search by file path
                ->with(['requirement', 'user']) // Eager load relationships
                ->get();

            return view('admin.views.archive', compact('archivedClearances', 'search'));
        } catch (\Exception $e) {
            Log::error('Error fetching archived clearances: ' . $e->getMessage());
            return view('admin.views.archive', [
                'archivedClearances' => collect(), // Pass an empty collection
                'error' => 'Failed to load archived clearances.'
            ]);
        }
    }

    public function adminIdManagement(): View
    {
        $users = User::all();
        $adminIds = AdminId::orderBy('is_assigned', 'asc')->get(); // Sort by is_assigned
        $programHeadDeanIds = ProgramHeadDeanId::orderBy('is_assigned', 'asc')->get(); // Sort by is_assigned
        return view('admin.views.admin-id-management', compact('adminIds', 'programHeadDeanIds', 'users'));
    }

    public function profileEdit(): View
    {
        $user = Auth::user();
        $departments = Department::with('programs')->get();
        $programs = Program::all();
        $campuses = Campus::all();

        // Fetch the user's sub-programs
        $subProgram = SubProgram::where('user_id', $user->id)->first();

        $noActiveClearance = true;

        return view ('admin.profile.edit', compact('user', 'departments', 'noActiveClearance', 'campuses', 'programs', 'subProgram'));
    }
    /////////////////////////////////////////////// End of Views Controller ////////////////////////////////////////////////

    /////////////////////////////////////////////// Admin ID Management Controller /////////////////////////////////////////////////
    public function createAdminId(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|unique:admin_ids,admin_id',
        ]);

        AdminId::create([
            'admin_id' => $request->input('admin_id'),
        ]);

        return redirect()->route('admin.adminIdManagement')->with('success', 'Admin ID created successfully.');
    }

    public function assignAdminId(Request $request)
    {
        $request->validate([
            'adminId' => 'required|exists:admin_ids,id',
            'userId' => 'required|exists:users,id',
        ]);

        $adminId = AdminId::find($request->adminId);
        $adminId->is_assigned = true;
        $adminId->user_id = $request->userId;
        $adminId->save();

        $user = User::find($request->userId);
        $user->admin_id_registered = $adminId->admin_id;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function deleteAdminId($id)
    {
        $adminId = AdminId::findOrFail($id);
        // if ($adminId->is_assigned) {
        //     return redirect()->route('admin.adminIdManagement')->withErrors(['error' => 'Cannot delete an assigned Admin ID.']);
        // }
        $adminId->delete();

        return redirect()->route('admin.adminIdManagement')->with('success', 'Admin ID deleted successfully.');
    }

    public function createProgramHeadDeanId(Request $request)
    {
        $request->validate([
            'identifier' => 'required|unique:program_head_dean_ids,identifier',
            'type' => 'nullable|in:Program-Head,Dean',
        ]);

        ProgramHeadDeanId::create([
            'identifier' => $request->input('identifier'),
            'type' => $request->input('type') ?? null,
            'is_assigned' => false,
            'user_id' => null,
        ]);

        return redirect()->route('admin.adminIdManagement')->with('success', 'Program Head/Dean ID created successfully.');
    }

    public function assignProgramHeadDeanId(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:program_head_dean_ids,id',
            'userId' => 'required|exists:users,id',
        ]);

        $id = ProgramHeadDeanId::find($request->id);
        $id->is_assigned = true;
        $id->user_id = $request->userId;
        $id->save();

        if ($id->type === 'Program-Head') {
            $user = User::find($request->userId);
            $user->program_head_id = $id->identifier;
        } else {
            $user = User::find($request->userId);
            $user->dean_id = $id->identifier;
        }

        $user->save();

        return response()->json(['success' => true]);
    }

    public function deleteProgramHeadDeanId($id)
    {
        $programHeadDeanId = ProgramHeadDeanId::findOrFail($id);

        // Forcefully remove the ID, regardless of assignment
        $programHeadDeanId->delete();

        return redirect()->route('admin.adminIdManagement')->with('success', 'Program Head/Dean ID deleted successfully.');
    }

    ////////////////////////////////////////////// Archive Controller /////////////////////////////////////////////////

    public function deleteArchivedFile(Request $request)
    {
        $path = $request->path;
        Log::info('Deleting file at path: ' . $path);

        try {
            // Check if the file exists
            if (!Storage::disk('local')->exists($path)) {
                return response()->json(['success' => false, 'message' => 'File does not exist'], 404);
            }

            // Delete the file from storage
            Storage::disk('local')->delete($path);

            // Delete the record from the database
            $deleted = UploadedClearance::where('file_path', $path)->delete();

            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'File deleted successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Database record not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting file'], 500);
        }
    }

    ////////////////////////////////////////////// DomPDF Controller or Generate Report /////////////////////////////////////////////////

    public function generateReport()
    {
        // Get the current admin's ID
        $adminId = Auth::id();

        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg'))); //working

        // Get only users managed by this admin
        $users = User::with('managingAdmins')
            ->whereHas('managingAdmins', function($query) use ($adminId) {
                $query->where('admin_id', $adminId);
            })
            ->get();

        $pdf = Pdf::loadView('admin.views.reports.admin-generate', compact('users', 'omscLogo', 'iqaLogo'));

        SubmittedReport::create([
            'admin_id' => Auth::id(),
            'user_id' => null,
            'title' => 'Admin '. Auth::user()->name .' Report Generated',
            'transaction_type' => 'Generated Report',
            'status' => 'Completed',
        ]);

        return $pdf->stream(Auth::user()->name.'-report-manage-faculty.pdf');
    }

    public function generateManagedFacultyReport()
    {
        $adminId = Auth::id();
        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg'))); //working

        $faculty = User::whereHas('managingAdmins', function($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })->get();

        foreach ($faculty as $member) {
            $member->program_name = Program::find($member->program_id)->name ?? 'N/A';
        }

        $pdf = Pdf::loadView('admin.views.reports.faculty-generate', compact('faculty', 'omscLogo', 'iqaLogo'));

        SubmittedReport::create([
            'admin_id' => Auth::id(),
            'user_id' => null,
            'title' => 'Admin '. Auth::user()->name .' Report Generated for Managed Faculty',
            'transaction_type' => 'Generated Report',
            'status' => 'Completed',
        ]);

        return $pdf->stream('managed-faculty-report.pdf');
    }

    public function generateFacultyReport(Request $request)
    {
        $query = User::with(['department', 'program']);

        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg'))); //working

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('program')) {
            $query->where('program_id', $request->program);
        }

        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $faculty = $query->get(); // Use $faculty here

        foreach ($faculty as $member) {
            $member->program_name = Program::find($member->program_id)->name ?? 'N/A';
        }

        $pdf = Pdf::loadView('admin.views.reports.faculty-generate', compact('faculty', 'omscLogo', 'iqaLogo'));

        $departmentName = $request->filled('department') ? Department::find($request->department)->name : 'All';
        $programName = $request->filled('program') ? Program::find($request->program)->name : 'All';

        SubmittedReport::create([
            'admin_id' => Auth::id(),
            'user_id' => null,
            'title' => Auth::user()->name . ' Report Generated for ' . $departmentName . ', ' . $programName . ', ' . ($request->position ?? 'All') . ' Faculty',
            'transaction_type' => 'Generated Report',
            'status' => 'Completed',
        ]);
        return $pdf->stream(Auth::user()->name.'-report-custom-faculty.pdf');
    }


    /////////////////////////////////////////////// Admin Faculty Assigned or Managed /////////////////////////////////////////////////
    public function assignFaculty(Request $request)
    {
        $validatedData = $request->validate([
            'admin_id' => 'required|exists:users,id',
            'faculty_ids' => 'array', // Allow empty array
            'faculty_ids.*' => 'exists:users,id',
        ]);

        // Get admin name
        $adminName = User::find($validatedData['admin_id'])->name;

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

                // Update checked_by field for the assigned faculty with admin name
                User::where('id', $facultyId)->update([
                    'checked_by' => $adminName
                ]);
            }
        }

        // Update checked_by to NULL for unassigned faculty
        User::whereNotIn('id', $validatedData['faculty_ids'] ?? [])
            ->where('checked_by', $adminName)
            ->update(['checked_by' => null]);

        return response()->json(['success' => true, 'message' => 'Faculty members assigned successfully.']);
    }

    public function manageFaculty()
    {
        try {
            $query = User::with(['department', 'program', 'managingAdmins'])
                ->where('user_type', 'Faculty');

            // Filter based on user role
            $user = Auth::user();

            if ($user->user_type === 'Admin' && !$user->campus_id) {
                // Admin with no campus can view all users
            } elseif ($user->user_type === 'Admin') {
                // Admin can only see faculty in their campus
                $query->where('campus_id', $user->campus_id);
            } elseif ($user->user_type === 'Dean') {
                // Dean can only see faculty in their department
                $query->where('department_id', $user->department_id);
            } elseif ($user->user_type === 'Program-Head') {
                // Program Head can only see faculty in their program
                $query->where('program_id', $user->program_id)
                      ->orWhereHas('subPrograms', function($sq) use ($user) {
                          $sq->where('program_id', $user->program_id);
                      });
            }

            $allFaculty = $query->get()
                ->map(function ($faculty) {
                    $faculty->managed_by = $faculty->managingAdmins->pluck('name')->join(', ') ?: 'None';
                    return $faculty;
                });

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

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Department added successfully. by '. Auth::user()->name ."\n" . 'a college department named '. $data['name'],
                'transaction_type' => 'Added Department',
                'status' => 'Completed',
            ]);

            session()->flash('successAddCollegeDepartment', 'Department added successfully.'. "\n" . 'a college department named '. $data['name']);

            return redirect()->route('admin.views.college')->with('success', 'Department added successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add department.');
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

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Program added successfully. by '. Auth::user()->name ."\n" . 'a college program named '. $request->name,
                'transaction_type' => 'Added Program',
                'status' => 'Completed',
            ]);

            session()->flash('successAddCollegeProgram', 'Program added successfully.'. "\n" . 'a college program named '. $request->name);

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

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Programs added successfully. by '. Auth::user()->name ."\n" . 'a college programs named '. $request->programs[0]['name'],
                'transaction_type' => 'Added Programs',
                'status' => 'Completed',
            ]);

            session()->flash('successAddCollegePrograms', 'Programs added successfully.'. "\n" . 'a college programs named '. $request->programs[0]['name']);

            // Use 'success' as the session key
            return redirect()->route('admin.views.college')->with('successAddCollegePrograms', 'Programs added successfully redirect.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add programs.');
            return redirect()->route('admin.views.college')->with('error', 'Failed to add programs.');
        }
    }

    public function destroyCollegeProgram($id)
    {
        try {
            $program = Program::findOrFail($id);
            $program->delete();

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                    // Start of Selection
                    'title' => "Program deleted successfully. by " . Auth::user()->name . "\n" . "a college program named " . $program->name,
                'transaction_type' => 'Deleted Program',
                'status' => 'Completed',
            ]);

            session()->flash('successDeleteCollegeProgram', 'Program deleted successfully.'. "\n" . 'a college program named '. $program->name);

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

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Department deleted successfully. by '. Auth::user()->name ."\n" . 'a college department named '. $department->name,
                'transaction_type' => 'Deleted Department',
                'status' => 'Completed',
            ]);

            session()->flash('successDeleteCollegeDepartment', 'Department deleted successfully.'. "\n" . 'a college department named '. $department->name);

            return response()->json(['success' => true, 'message' => 'Department deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting department: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete department.'], 500);
        }
    }

    public function updateDepartment(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'campus_id' => 'required|exists:campuses,id', // Validate campus_id
            'new_programs' => 'array',
            'remove_programs' => 'array',
        ]);

        try {
            $department = Department::findOrFail($id);
            $data = $request->only('name', 'description', 'campus_id');

            if ($request->hasFile('profile_picture')) {
                $filePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $data['profile_picture'] = $filePath;
            }

            $department->update($data);

            if ($request->filled('new_programs')) {
                foreach ($request->new_programs as $programName) {
                    $department->programs()->create(['name' => $programName]);
                }
            }

            if ($request->filled('remove_programs')) {
                $department->programs()->whereIn('id', $request->remove_programs)->delete();
            }

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Department updated successfully. by '. Auth::user()->name ."\n" . 'a college department named '. $department->name,
                'transaction_type' => 'Updated Department',
                'status' => 'Completed',
            ]);

            session()->flash('successUpdateCollegeDepartment', 'Department updated successfully session.');


            return redirect()->route('admin.views.college')->with('successUpdateCollegeDepartment', 'Department updated successfully redirect.');
        } catch (\Exception $e) {
            return redirect()->route('admin.views.college')->with('error', 'Failed to update department.');
        }
    }

    public function removeProgram($programId): JsonResponse
    {
        try {
            $program = Program::findOrFail($programId);
            $program->delete();

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Program removed successfully. by '. Auth::user()->name .'\n' . 'a college program named '. $program->name,
                'transaction_type' => 'Removed Program',
                'status' => 'Completed',
            ]);

            session()->flash('successRemoveCollegeProgram', 'Program removed successfully.'. '\n' . 'a college program named '. $program->name);

            return response()->json(['success' => true, 'message' => 'Program removed successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove program.'], 500);
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

            // Get program name
            $program = Program::findOrFail($validatedData['program_id']);
            $validatedData['program'] = $program->name;

            $facultyMember->update($validatedData);

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Faculty member updated successfully. by '. Auth::user()->name .'\n' . 'a faculty member named '. $facultyMember->name,
                'transaction_type' => 'Updated Faculty',
                'status' => 'Completed',
            ]);

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

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => 'Faculty member deleted successfully. by '. Auth::user()->name .'\n' . 'a faculty member named '. $facultyMember->name,
                'transaction_type' => 'Deleted   Faculty',
                'status' => 'Completed',
            ]);

            session()->flash('successDeleteFaculty', 'Faculty member deleted successfully.'. '\n' . 'a faculty member named '. $facultyMember->name);

            return response()->json(['success' => true, 'message' => 'Faculty member deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting faculty member: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete faculty member.'], 500);
        }
    }
    ///////////////////////////////////////////// Clearance.view Checklist User Update/////////////////////////////////////////////
    public function updateUserClearance(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:user_clearances,id',
                'shared_clearance_id' => 'required|exists:shared_clearances,id',
            ]);

            $userClearance = UserClearance::findOrFail($validated['id']);
            $userClearance->shared_clearance_id = $validated['shared_clearance_id'];
            $userClearance->save();

            return response()->json([
                'success' => true,
                'message' => 'Clearance updated successfully.',
                'userClearance' => $userClearance,
            ]);
        } catch (\Exception $e) {
            Log::error('Clearance Update Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update clearance.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
