<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\UserClearance;
use App\Models\Clearance;
use App\Models\ClearanceRequirement;
use App\Models\SharedClearance;
use App\Models\ClearanceFeedback;
use App\Models\UploadedClearance;
use App\Models\SubmittedReport;
use App\Models\User;
use App\Models\Department;
use App\Models\Program;
class ClearanceController extends Controller
{
    // Display the clearance management page
    public function index()
    {
        $clearances = Clearance::all();
        return view('admin.views.clearances.clearance-management', compact('clearances'));
    }

    // Store a new clearance
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'nullable|integer',
            'type' => 'required|in:Permanent,Part-Timer,Temporary',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $clearance = Clearance::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Clearance added successfully',
                'clearance' => [
                    'id' => $clearance->id,
                    'document_name' => $clearance->document_name,
                ],
            ]);

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => $clearance->document_name,
                'transaction_type' => 'Created Clearance Checklist',
                'status' => 'Completed',
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating clearance: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the clearance.'
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $adminId = Auth::id();
    
        $users = User::with(['userClearances.sharedClearance.clearance'])
            ->whereHas('managingAdmins', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('id', 'like', '%' . $query . '%');
            })
            ->get();
    
        return view('admin.views.clearances.clearance-check', compact('users', 'query'));
    }

    // Fetch a clearance for editing
    public function edit($id)
    {
        $clearance = Clearance::find($id);
        if ($clearance) {
            return response()->json([
                'success' => true,
                'clearance' => $clearance
            ]);

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => $clearance->document_name,
                'transaction_type' => 'Edited Clearance Checklist',
                'status' => 'Completed',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Clearance not found.'
            ], 404);
        }
    }

    // Update a clearance
    public function update(Request $request, $id)
    {
        $clearance = Clearance::find($id);
        if (!$clearance) {
            return response()->json([
                'success' => false,
                'message' => 'Clearance not found.'
            ], 404);
        }

        $request->validate([
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'nullable|integer',
            'type' => 'required|in:Permanent,Part-Timer,Temporary',
        ]);

        SubmittedReport::create([
            'admin_id' => Auth::id(),
            'user_id' => null,
            'title' => $clearance->document_name,
            'transaction_type' => 'Edited Clearance Checklist',
            'status' => 'Completed',
        ]);

        $clearance->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Clearance updated successfully.',
            'clearance' => $clearance
        ]);
    }

    public function share(Request $request, $id)
    {
        $clearance = Clearance::findOrFail($id);

        // Check if the clearance is already shared
        $existingShare = SharedClearance::where('clearance_id', $clearance->id)->first();
        if ($existingShare) {
            return response()->json([
                'success' => false,
                'message' => 'Clearance is already shared.',
            ]);
        }

        DB::beginTransaction();

        try {
            SharedClearance::create([
                'clearance_id' => $clearance->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Clearance shared successfully.',
            ]);

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => $clearance->document_name,
                'transaction_type' => 'Shared Clearance Checklist',
                'status' => 'Completed',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to share clearance.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete a clearance
    public function destroy($id)
    {
        $clearance = Clearance::find($id);
        if (!$clearance) {
            return response()->json([
                'success' => false,
                'message' => 'Clearance not found.'
            ], 404);
        }

        $clearance->delete();

        SubmittedReport::create([
            'admin_id' => Auth::id(),
            'user_id' => null,
            'title' => $clearance->document_name,
            'transaction_type' => 'Deleted Clearance Checklist',
            'status' => 'Completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Clearance deleted successfully.'
        ]);
    }

    ///////////////////////////////////////// Clearance Requirements ///////////////////////////////////////
  

    public function showUserClearance($id)
    {
        $userClearance = UserClearance::with(['sharedClearance.clearance.requirements', 'uploadedClearances.requirement.feedback', 'user'])
        ->where('user_id', $id)
        ->first();

        if (!$userClearance) {
            return redirect()->route('admin.clearance.check')
                ->with('error', 'This user does not have a clearance copy yet.');
        }

        $user = User::with(['college', 'program'])->find($userClearance->user_id);
        $college = Department::find($user->department_id);
        $program = Program::find($user->program_id);

        if (!$user) {
            abort(404, 'User not found.');
        }

        return view('admin.views.clearances.user-clearance-details', compact('userClearance', 'user', 'college', 'program'));
    }
    
    public function checkClearances(Request $request)
    {
        $adminId = Auth::id(); // Get the current admin's ID

        // Fetch all users managed by the current admin
        $users = User::with(['userClearances.sharedClearance.clearance'])
            ->whereHas('managingAdmins', function($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->get();
    
            
        return view('admin.views.clearances.clearance-check', compact('users'));
    }

    public function approveClearance($id)
    {
        $userClearance = UserClearance::find($id);
        $userClearance->status = 'Approved';
        $userClearance->save();
        
    }
    /**
     * Display the requirements for a specific clearance.
     */
    public function requirements(Request $request, $clearanceId)
    {
        $clearance = Clearance::with('requirements')->find($clearanceId);
        if ($request->ajax()) {
            if ($clearance) {
                return response()->json([
                    'success' => true,
                    'requirements' => $clearance->requirements,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Clearance not found.'
                ], 404);
            }
        } else {
            // If not AJAX, load the requirements blade view
            if ($clearance) {
                return view('admin.views.clearances.clearance-requirements', compact('clearance'));
            } else {
                abort(404);
            }
        }
    }

    /**
     * Store a new requirement for a clearance.
     */
    public function storeRequirement(Request $request, $clearanceId)
    {
        $clearance = Clearance::findOrFail($clearanceId);

        $request->validate([
            'requirement' => 'required|string',
        ]);

        $requirement = $clearance->requirements()->create([
            'requirement' => $request->requirement,
        ]);

        // Update the number_of_requirements
        $clearance->number_of_requirements = $clearance->requirements()->count();
        $clearance->save();

        return response()->json([
            'success' => true,
            'message' => 'Requirement added successfully.',
            'requirement' => $requirement,
        ]);
    }

    public function storeFeedback(Request $request)
    {
        $validatedData = $request->validate([
            'requirement_id' => 'required|exists:clearance_requirements,id',
            'user_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'signature_status' => 'required|in:On Check,Signed,Return',
        ]);
    
        // Find the feedback record
        $feedback = ClearanceFeedback::firstOrNew([
            'requirement_id' => $validatedData['requirement_id'],
            'user_id' => $validatedData['user_id'],
        ]);
    
        // Update the fields
        $feedback->message = $validatedData['message'];
        $feedback->signature_status = $validatedData['signature_status'];
        $feedback->is_archived = false; // Set to false
        $feedback->save();
        
        // Update user's last_clearance_update timestamp
        User::where('id', $validatedData['user_id'])->update([
            'last_clearance_update' => now()
        ]);
    
        Log::info('Feedback updated:', $feedback->toArray());
    
        app('App\Http\Controllers\AdminController')->updateClearanceStatus($validatedData['user_id']);
    
        return response()->json([
            'success' => true,
            'message' => 'Feedback saved successfully.',
            'feedback' => $feedback,
        ]);
    }

    /**
     * Fetch a requirement for editing.
     */
    public function editRequirement($clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->find($requirementId);

        if ($requirement) {
            return response()->json([
                'success' => true,
                'requirement' => $requirement,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found.'
            ], 404);
        }
    }

    /**
     * Update a requirement.
     */
    public function updateRequirement(Request $request, $clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->find($requirementId);

        if (!$requirement) {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found.'
            ], 404);
        }

        $request->validate([
            'requirement' => 'required|string',
        ]);

        $requirement->update([
            'requirement' => $request->requirement,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Requirement updated successfully.',
            'requirement' => $requirement,
        ]);
    }

    /**
     * Delete a requirement.
     */
    public function destroyRequirement($clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->find($requirementId);

        if (!$requirement) {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found.'
            ], 404);
        }

        $requirement->delete();

        // Update the number_of_requirements
        $clearance = Clearance::findOrFail($clearanceId);
        $clearance->number_of_requirements = $clearance->requirements()->count();
        $clearance->save();

        return response()->json([
            'success' => true,
            'message' => 'Requirement deleted successfully.',
        ]);
    }

    /////////////////////////////////// Shared Fetch Methods ////////////////////////////////////////////////
    public function shared()
    {
        $sharedClearances = SharedClearance::with('clearance')->get()->map(function ($shared) {
            return [
                'id' => $shared->id,
                'document_name' => $shared->clearance->document_name,
                'units' => $shared->clearance->units,
                'type' => $shared->clearance->type,
            ];
        });

        return response()->json([
            'success' => true,
            'sharedClearances' => $sharedClearances,
        ]);
    }

    public function removeShared($id)
    {
        $sharedClearance = SharedClearance::find($id);

        if (!$sharedClearance) {
            return response()->json([
                'success' => false,
                'message' => 'Shared clearance not found.',
            ], 404);
        }

        $sharedClearance->delete();

        SubmittedReport::create([
            'admin_id' => Auth::id(),
            'user_id' => null,
            'title' => 'Removed shared clearance checklist: ' . $sharedClearance->clearance->document_name,
            'transaction_type' => 'Remove Shared' . "\n" .
                                'Clearance Checklist',
            'status' => 'Completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shared clearance removed successfully.',
        ]);
    }

    /////////////////////////////////// Archive Methods ////////////////////////////////////////////////
    public function archiveClearances(Request $request)
    {
        $ids = $request->input('ids'); // Array of clearance IDs to archive

        try {
            DB::transaction(function () use ($ids) {
                UploadedClearance::whereIn('shared_clearance_id', $ids)->update(['is_archived' => true]);
                ClearanceFeedback::whereIn('requirement_id', $ids)->update(['is_archived' => true, 'signature_status' => 'On Check']);
            });

            return response()->json(['success' => true, 'message' => 'Clearances archived successfully.']);
        } catch (\Exception $e) {
            Log::error('Archiving Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to archive clearances.'], 500);
        }
    }

    /////////////////////////////////// User Clearance Reset ////////////////////////////////////////////////
    public function resetUserClearances()
    {
        $adminId = Auth::id();

        try {
            DB::transaction(function () use ($adminId) {
                // Get all users managed by the current admin
                $userIds = User::whereHas('managingAdmins', function($q) use ($adminId) {
                    $q->where('admin_id', $adminId);
                })->pluck('id');

                $user = User::findOrFail($userIds);

                // Archive all feedback and uploaded files for these users
                ClearanceFeedback::whereIn('user_id', $userIds)->update([
                    'is_archived' => true,
                    'signature_status' => 'On Check' // Reset signature status
                ]);

                UploadedClearance::whereIn('user_id', $userIds)->update(['is_archived' => true]);

                // Reset user clearance status to pending
                User::whereIn('id', $userIds)->update(['clearances_status' => 'pending']);

                SubmittedReport::create([
                    'admin_id' => Auth::id(),
                    'user_id' => $userIds,
                    'title' => 'Reset user clearances checklist' . "\n" .
                                'for ' . $user->name,
                    'transaction_type' => 'Reset Checklist',
                    'status' => 'Completed',
                ]);
            });

            return response()->json(['success' => true, 'message' => 'User clearances reset successfully.']);
        } catch (\Exception $e) {
            Log::error('Resetting User Clearances Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to reset user clearances.'], 500);
        }
    }

    public function resetSpecificUserClearance($userId)
    {
        try {
            DB::transaction(function () use ($userId) {
                // Get user details first
                $user = User::findOrFail($userId);

                // Archive all feedback and uploaded files for this user
                ClearanceFeedback::where('user_id', $userId)->update([
                    'is_archived' => true,
                    'signature_status' => 'On Check' // Reset signature status
                ]);

                UploadedClearance::where('user_id', $userId)->update(['is_archived' => true]);

                // Reset user clearance status to pending in the users table
                User::where('id', $userId)->update(['clearances_status' => 'Pending']);

                SubmittedReport::create([
                    'admin_id' => Auth::id(),
                    'user_id' => $userId,
                    'title' => 'Reset user clearances checklist of ' . $user->name,
                    'transaction_type' => 'Reset Checklist',
                    'status' => 'Completed',
                ]);
            });

            return response()->json(['success' => true, 'message' => 'User clearance reset successfully.']);
        } catch (\Exception $e) {
            Log::error('Resetting User Clearance Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to reset user clearance.'], 500);
        }
    }

    public function resetSelected(Request $request)
    {
        $userIds = $request->input('user_ids', []);
    
        if (empty($userIds)) {
            return response()->json(['success' => false, 'message' => 'No users selected.']);
        }
    
        try {
            DB::transaction(function () use ($userIds) {

                $user = User::findOrFail($userIds);
                
                foreach ($userIds as $userId) {
                    // Archive all feedback and uploaded files for this user
                    ClearanceFeedback::where('user_id', $userId)->update([
                        'is_archived' => true,
                        'signature_status' => 'On Check' // Reset signature status
                    ]);
    
                    UploadedClearance::where('user_id', $userId)->update(['is_archived' => true]);
    
                    // Reset user clearance status to pending in the users table
                    User::where('id', $userId)->update(['clearances_status' => 'Pending']);

                    SubmittedReport::create([
                        'admin_id' => Auth::id(),
                        'user_id' => $userId,
                        'title' => 'Reset user clearances checklist of ' . $user->name,
                        'transaction_type' => 'Reset Checklist',
                        'status' => 'Completed',
                    ]);
                }
            });
    
            return response()->json(['success' => true, 'message' => 'Selected user clearances reset successfully.']);
        } catch (\Exception $e) {
            Log::error('Resetting User Clearance Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to reset user clearances.'], 500);
        }
    }
}
