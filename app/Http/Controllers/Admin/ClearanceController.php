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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

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

            
            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => $clearance->document_name,
                'transaction_type' => 'Created Clearance Checklist',
                'status' => 'Completed',
            ]);
            
            session()->flash('successAdd', 'Clearance added successfully.', $clearance->document_name);
            
            return response()->json([
                'success' => true,
                'message' => 'Clearance added successfully',
                'clearance' => [
                    'id' => $clearance->id,
                    'document_name' => $clearance->document_name,
                ],
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error creating clearance: ' . $e->getMessage());

            session()->flash('error', 'An error occurred while adding the clearance.');

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
        try {
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

                session()->flash('successEdit', 'Clearance edited successfully.', $clearance->document_name);

                // Simulate an error
                // return response()->json([
                //     'success' => false,
                //     'message' => 'Simulated server error.'
                // ], 500);

                return response()->json([
                    'success' => true,
                    'message' => 'Clearance edited successfully.',
                    'clearance' => $clearance
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Clearance not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error editing clearance: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while editing the clearance.'
            ], 500);
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

        session()->flash('successUpdate', 'Clearance updated successfully.', $clearance->document_name);
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
            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => null,
                'title' => $clearance->document_name,
                'transaction_type' => 'Shared Clearance Checklist',
                'status' => 'Completed',
            ]);

            DB::commit();
            

            return response()->json([
                'success' => true,
                'message' => 'Clearance shared successfully.',
            ]);


            session()->flash('successShared', 'Clearance shared successfully.', $clearance->document_name);
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
        try {
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

            session()->flash('successDelete', 'Clearance deleted successfully.', $clearance->document_name);

            return response()->json([
                'success' => true,
                'message' => 'Clearance deleted successfully.'
            ]);
        } 
        catch (\Exception $e) {

            session()->flash('error', 'An error occurred while deleting the clearance.');

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the clearance.'
            ], 500);
        }
    }

    ///////////////////////////////////////// Clearance View Management ///////////////////////////////////////

    public function getClearanceDetails($id)
    {
        $clearance = Clearance::with('requirements')->find($id);
 
        if ($clearance) {
            Log::info('Clearance details fetched:', ['clearance' => $clearance]);
            return response()->json([
                'success' => true,
                'clearance' => [
                    'name' => $clearance->document_name,
                    'requirements' => $clearance->requirements->map(function ($requirement) {
                        return ['requirement' => $requirement->requirement];
                    }),
                ],
            ]);
        } else {
            Log::warning('Clearance not found for ID:', ['id' => $id]);
            return response()->json(['success' => false, 'message' => 'Clearance not found.'], 404);
        }
    }

    public function getAllClearances()
    {
        $clearances = Clearance::with('requirements')->get();

        Log::info('All clearances fetched:', ['clearances' => $clearances]);

        return response()->json([
            'success' => true,
            'clearances' => $clearances
        ]);
    }
    ///////////////////////////////////////// Generate Clearance Checklist Info ///////////////////////////////////////
    public function generateChecklistInfo($id)
    {
        $clearance = Clearance::with('requirements')->find($id);

        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg'))); //working


        if (!$clearance) {
            return redirect()->back()->with('error', 'Clearance not found.');
        }

        $pdf = PDF::loadView('admin.views.reports.generate-checklist-info', compact('clearance', 'omscLogo', 'iqaLogo'))
            ->setPaper('legal', 'portrait');
        return $pdf->stream('clearance_' . $clearance->id . '_' . $clearance->document_name . '.pdf');
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

        session()->flash('successAddRequirement', 'Clearance added successfully.', $clearance->document_name);
    }

    public function storeFeedback(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'requirement_id' => 'required|exists:clearance_requirements,id',
                'user_id' => 'required|exists:users,id',
                'message' => 'nullable|string',
                'signature_status' => 'required|in:Checking,Complied,Resubmit',
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

            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => $validatedData['user_id'],
                'title' => 'Clearance Checklist: ',
                'transaction_type' => $feedback->signature_status == 'Resubmit' ? 'Resubmit Document' : 'Validated Document',
                'status' => 'Completed',
            ]);
            
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

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving feedback.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch a requirement for editing.
     */
    public function editRequirement($clearanceId, $requirementId)
    {
        try {
            $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->find($requirementId);

            if ($requirement) {
                return response()->json([
                    'success' => true,
                    'requirement' => $requirement,
                ]);

                session()->flash('successEditRequirement', 'Requirement updated successfully.', $clearance->document_name);

                return response()->json([
                    'success' => true,
                    'message' => 'Requirement updated successfully.',
                    'requirement' => $requirement,
                ]);
            } else {
                session()->flash('error', 'Requirement not found.');
                return response()->json([
                    'success' => false,
                    'message' => 'Requirement not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while fetching the requirement.');
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the requirement.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a requirement.
     */
    public function updateRequirement(Request $request, $clearanceId, $requirementId)
    {
        try {
            $clearance = Clearance::findOrFail($clearanceId);
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

            session()->flash('successEditRequirement', 'Requirement updated successfully.', $clearance->document_name);

            return response()->json([
                'success' => true,
                'message' => 'Requirement updated successfully.',
                'requirement' => $requirement,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while updating the requirement.');
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the requirement.',
            ], 500);
        }
    }

    /**
     * Delete a requirement.
     */
    public function destroyRequirement($clearanceId, $requirementId)
    {
        try {
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

            session()->flash('successDeleteRequirement', 'Requirement deleted successfully.', $clearance->document_name);

            return response()->json([
                'success' => true,
                'message' => 'Requirement deleted successfully.',
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the requirement.');

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the requirement.',
                'error' => $e->getMessage()
            ], 500);
        }
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
            'title' => 'Removed shared clearance checklist: ' . $sharedClearance->clearance->document_name . ' by ' . Auth::user()->name,
            'transaction_type' => 'Remove Shared' . "\n" .
                                'Clearance Checklist',
            'status' => 'Completed',
        ]);

        session()->flash('successRemovedShared', 'Shared clearance removed successfully.');

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
                ClearanceFeedback::whereIn('requirement_id', $ids)->update(['is_archived' => true, 'signature_status' => 'Checking']);
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
                    'signature_status' => 'Checking' // Reset signature status
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
                    'signature_status' => 'Checking' // Reset signature status
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
                        'signature_status' => 'Checking' // Reset signature status
                    ]);
    
                    UploadedClearance::where('user_id', $userId)->update(['is_archived' => true]);
    
                    // Reset user clearance status to pending in the users table
                    User::where('id', $userId)->update(['clearances_status' => 'Pending']);

                    // Get the user record for this ID
                    $currentUser = User::find($userId);

                    SubmittedReport::create([
                        'admin_id' => Auth::id(),
                        'user_id' => $userId,
                        'title' => 'Reset user clearances checklist of ' . $currentUser->name,
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

    /////////////////////////////////// Clearance.view Show Methods ////////////////////////////////////////////////
    public function assignClearanceCopy(Request $request)
    {
        try {
            $userId = $request->input('id');
            $sharedClearanceId = $request->input('shared_clearance_id');
            
            $user = User::findOrFail($userId);
            $sharedClearance = SharedClearance::findOrFail($sharedClearanceId);
    
            // Check if the user already has this clearance
            $existingCopy = UserClearance::where('shared_clearance_id', $sharedClearanceId)
                ->where('user_id', $userId)
                ->first();
    
            if ($existingCopy) {
                return response()->json([
                    'success' => false,
                    'message' => 'User already has a copy of this clearance.'
                ], 400);
            }
    
            // Deactivate other clearances
            UserClearance::where('user_id', $userId)
                ->update(['is_active' => false]);
    
            // Create a new user clearance and set it as active
            $userClearance = UserClearance::create([
                'shared_clearance_id' => $sharedClearanceId,
                'user_id' => $userId,
                'is_active' => true,
            ]);
    
            SubmittedReport::create([
                'admin_id' => Auth::id(),
                'user_id' => $userId,
                'title' => 'Assigned clearance copy to ' . $user->name,
                'transaction_type' => 'Assigned Checklist',
                'status' => 'Completed',
            ]);
    
            // Load the relationships we need
            $userClearance->load('sharedClearance.clearance');
    
            return response()->json([
                'success' => true,
                'message' => 'Clearance assigned successfully.',
                'userClearance' => $userClearance
            ]);
        } catch (\Exception $e) {
            Log::error('Assigning Clearance Copy Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign clearance copy: ' . $e->getMessage()
            ], 500);
        }
    }

    public function searchUserClearances(Request $request)
    {
        $query = $request->input('search');
        $adminId = Auth::id();

        $users = User::with([
            'userClearances.sharedClearance.clearance',
            'managingAdmins'
        ])
            ->whereHas('managingAdmins', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('id', 'like', '%' . $query . '%');
            })
            ->get();

        return view('admin.views.clearances', compact('users', 'query'));
    }
}
