<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SharedClearance;
use App\Models\UploadedClearance;
use App\Models\ClearanceRequirement;
use App\Models\UserClearance;
use App\Models\SubmittedReport;
use App\Models\Clearance;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserNotification;
use App\Models\ClearanceFeedback;
class ClearanceController extends Controller
{/**
     * Display a listing of shared clearances for the faculty.
     */
    public function index()
    {
        $user = Auth::user();
        $userUnits = $user->units;
        $userPosition = $user->position;
    
        // Get all shared clearances with their associated clearance data
        $sharedClearances = SharedClearance::with('clearance')->get();
    
        // Filter shared clearances based on position and units
        $filteredClearances = $sharedClearances->filter(function ($sharedClearance) use ($userUnits, $userPosition) {
            $clearanceUnits = $sharedClearance->clearance->units;
            $clearanceType = $sharedClearance->clearance->type;
    
            // For Dean and Program-Head
            if ($userPosition === 'Dean' || $userPosition === 'Program-Head') {
                // If user has no units, fetch all clearances of matching position
                if (is_null($userUnits)) {
                    return $clearanceType === $userPosition;
                }
                
                // If clearance has units and user has units, check if they match
                if (!is_null($clearanceUnits)) {
                    return $clearanceType === $userPosition && $clearanceUnits == $userUnits;
                }
                
                // If clearance has no units but user has units, still fetch it
                return $clearanceType === $userPosition;
            }
    
            // For Permanent positions (FullTime and PartTime)
            if (in_array($userPosition, ['Permanent-FullTime', 'Permanent-PartTime'])) {
                return $clearanceType === 'Permanent' && $clearanceUnits == $userUnits;
            }
    
            // For Temporary position
            if ($userPosition === 'Temporary') {
                return $clearanceType === 'Temporary' && $clearanceUnits == $userUnits;
            }
    
            // For Part-Timer position
            if ($userPosition === 'Part-Timer') {
                if ($userUnits >= 12) {
                    // 12 units and above
                    return $clearanceType === 'Part-Timer' && $clearanceUnits >= 12;
                } else {
                    // Between 9 and 11 units
                    return $clearanceType === 'Part-Timer' && $clearanceUnits >= 0 && $clearanceUnits <= 11;
                }
            }
    
            return false;
        });
    
        // Get user_clearances to map shared_clearance_id to user_clearance_id
        // Only get active clearances
        $userClearances = UserClearance::where('user_id', $user->id)
            ->where('is_active', true)
            ->whereIn('shared_clearance_id', $filteredClearances->pluck('id'))
            ->pluck('id', 'shared_clearance_id')
            ->toArray();
    
        // Determine recommendations based on user's position and units
        $recommendations = $filteredClearances->filter(function ($sharedClearance) use ($user) {
            if ($user->position === 'Dean' || $user->position === 'Program-Head') {
                return $sharedClearance->clearance->type === $user->position;
            }
            return $sharedClearance->clearance->type === $user->position && 
                   $sharedClearance->clearance->units == $user->units;
        });
    
        // Get active clearances
        $activeClearances = UserClearance::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();
    
        return view('faculty.views.clearances.clearance-index', compact('filteredClearances', 'userClearances', 'recommendations', 'activeClearances'));
    }

    /**
     * Handle the user getting a copy of a shared clearance.
     */
    public function getCopy($id)
    {
        $user = Auth::user();
        $sharedClearance = SharedClearance::findOrFail($id);

        // Check if the user has already copied this clearance
        $existingCopy = UserClearance::where('shared_clearance_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingCopy) {
            return redirect()->route('faculty.clearances.index')->with('error', 'You have already copied this clearance.');
        }

        // Deactivate other clearances
        UserClearance::where('user_id', $user->id)
            ->update(['is_active' => false]);

        // Create a new user clearance and set it as active
        UserClearance::create([
            'shared_clearance_id' => $id,
            'user_id' => $user->id,
            'is_active' => true,
            
        ]);

        SubmittedReport::create([
            'user_id' => Auth::id(),
            'title' => 'Copied a clearance for ' . $sharedClearance->clearance->name,
            'transaction_type' => 'Aquired Checklist',
            'status' => 'Completed',
        ]);
        return redirect()->route('faculty.clearances.index')->with('success', 'Clearance copied and set as active successfully.');
    }
    
    public function removeCopy($id)
    {
        $user = Auth::user();

        try {
            // Find the user's clearance copy
            $userClearance = UserClearance::where('shared_clearance_id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();
    
            // Delete the user's clearance copy
            $userClearance->delete();

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'title' => 'Removed a clearance copy for ' . $userClearance->sharedClearance->clearance->name,
                'transaction_type' => 'Removed Checklist',
                'status' => 'Completed',
            ]);
    
            return redirect()->route('faculty.clearances.index')->with('success', 'Clearance copy removed successfully.');
        } catch (\Exception $e) {
            Log::error('Removing Clearance Copy Error: '.$e->getMessage());
    
            return redirect()->route('faculty.clearances.index')->with('error', 'Failed to remove clearance copy.');
        }
    }
    /**
     * Display the specified shared clearance and its requirements.
     */
    public function show($id)
    {
        $user = Auth::user();
        $userInfo = User::getAll();
        // Confirm that the user has copied this clearance
        $userClearance = UserClearance::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['sharedClearance.clearance.requirements' => function ($query) {
                $query->where('is_archived', false);
            }])
            ->firstOrFail();

        // Fetch already uploaded clearances by the user for this shared clearance
        $uploadedClearances = UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
            ->where('user_id', $user->id)
            ->where('is_archived', false)
            ->pluck('requirement_id')
            ->toArray();

        return view('faculty.views.clearances.clearance-show', compact('userClearance', 'uploadedClearances'));
    }

   
    /**
     * Handle the file upload for a specific requirement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $sharedClearanceId
     * @param  int  $requirementId
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, $sharedClearanceId, $requirementId)
    {
        $user = Auth::user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|file|mimes:pdf|max:200000', //,doc,docx,jpg,png',
            'title' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        if ($request->hasFile('files')) {
            try {
                $uploadedFiles = [];
                foreach ($request->file('files') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('uploads/faculty_clearances', $originalName, 'public');
    
                    $uploadedClearance = UploadedClearance::create([
                        'shared_clearance_id' => $sharedClearanceId,
                        'requirement_id' => $requirementId,
                        'user_id' => $user->id,
                        'file_path' => $path,
                    ]);

                    $uploadedFiles[] = $originalName;
                }
    
                $requirement = ClearanceRequirement::findOrFail($requirementId);
                $requirementName = $requirement->requirement;
                $fileCount = count($uploadedFiles);

                // Truncate requirement name if longer than 100 characters
                if (strlen($requirementName) > 100) {
                    $requirementName = substr($requirementName, 0, 100) . '...';
                }
    
                // Create single report for all uploaded files
                SubmittedReport::create([
                    'user_id' => Auth::id(),
                    'title' => "Uploaded {$fileCount} file(s) for requirement: {$requirementName}",
                    'transaction_type' => 'Uploaded',
                    'status' => 'Okay',
                ]);
                 // Create a notification for the user
                UserNotification::create([
                    'user_id' => $user->id, // or the admin's ID if you want to notify an admin
                    'admin_user_id' => null,
                    'notification_type' => 'file_upload',
                    'notification_data' => json_encode([
                        'message' => "You have successfully uploaded {$fileCount} file(s) for requirement: {$requirementName}.",
                    ]),
                    'is_read' => false,
                ]);

                ClearanceFeedback::create([
                    'user_id' => $user->id,
                    'requirement_id' => $requirementId,
                    'signature_status' => 'Checking',
                ]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Files uploaded successfully for requirement id:' . $requirementId .' with ' . $fileCount . ' file(s).',
                ]);
            } catch (\Exception $e) {
                Log::error('File Upload Error: '.$e->getMessage());

                SubmittedReport::create([
                    'user_id' => Auth::id(),
                    'title' => 'Failed to upload files',
                    'transaction_type' => 'Upload Failed',
                    'status' => 'Failed',
                ]);


                session()->flash('error', 'Failed to upload files.');
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload files.',
                ], 500);
            }
        }
    
        session()->flash('error', 'No files uploaded.');
        return response()->json([
            'success' => false,
            'message' => 'No files uploaded.',
        ], 400);
    }
    

    public function deleteFile($sharedClearanceId, $requirementId)
    {
        $user = Auth::user();

        DB::beginTransaction();
    
        try {
            // Retrieve all uploaded clearances for the specific requirement
            $uploadedClearances = UploadedClearance::where('shared_clearance_id', $sharedClearanceId)
                ->where('requirement_id', $requirementId)
                ->where('user_id', $user->id)
                ->where('is_archived', false)
                ->get();
    
            $deletedFiles = [];
    
            foreach ($uploadedClearances as $uploadedClearance) {
                // Check if the file exists before attempting to delete
                if (Storage::disk('public')->exists($uploadedClearance->file_path)) {
                    Storage::disk('public')->delete($uploadedClearance->file_path);
                }
    
                $deletedFiles[] = [
                    'file_name' => basename($uploadedClearance->file_path),
                    'deleted_at' => now(),
                ];
    
                // Delete the record from the database
                $uploadedClearance->delete();
            }
    
            $requirement = ClearanceRequirement::findOrFail($requirementId);
            $requirementName = $requirement->requirement;
            $fileCount = count($deletedFiles);

            // Truncate requirement name if longer than 100 characters
            if (strlen($requirementName) > 100) {
                $requirementName = substr($requirementName, 0, 100) . '...';
            }
    
            // Log the deletion in SubmittedReport
            SubmittedReport::create([
                'user_id' => Auth::id(),
                'admin_id' => null,
                'title' => "Deleted {$fileCount} file(s) for requirement: {$requirementName}",
                'transaction_type' => 'Removed File',
                'status' => 'Okay',
            ]);
    
            DB::commit();

            session()->flash('successDelete', 'All files related to this requirement have been deleted successfully and recorded.');
            
            return response()->json([
                'success' => true,
                'message' => 'All files related to this requirement have been deleted successfully and recorded.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('File Deletion Error: '.$e->getMessage());

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'title' => 'Failed to delete files',
                'transaction_type' => 'Delete',
                'status' => 'Failed',
            ]);

            session()->flash('error', 'Failed to delete the files.');
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the files.',
            ], 500);
        }
    }

    public function deleteSingleFile($sharedClearanceId, $requirementId, $fileId)
    {
        $user = Auth::user();

        try {
            // Retrieve the specific UploadedClearance record
            $uploadedClearance = UploadedClearance::where('id', $fileId)
                ->where('shared_clearance_id', $sharedClearanceId)
                ->where('requirement_id', $requirementId)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Delete the file from storage
            if (Storage::disk('public')->exists($uploadedClearance->file_path)) {
                Storage::disk('public')->delete($uploadedClearance->file_path);
            }

            // Delete the record from the database
            $uploadedClearance->delete();

            $requirement = ClearanceRequirement::findOrFail($requirementId);
            $requirementName = $requirement->requirement;

            // Truncate requirement name if longer than 100 characters
            if (strlen($requirementName) > 100) {
                $requirementName = substr($requirementName, 0, 100) . '...';
            }

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'admin_id' => null,
                'title' => "Deleted file for requirement: {$requirementName}",
                'transaction_type' => 'Delete',
                'status' => 'Okay',
            ]);

            session()->flash('successDelete', 'File deleted successfully.');

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Deleting Single File Error: '.$e->getMessage());

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'admin_id' => null,
                'title' => 'Failed to delete file',
                'transaction_type' => 'Removed', 
                'status' => 'Failed',
            ]);

            session()->flash('error', 'Failed to delete the file.');

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the file.',
            ], 500);
        }
    }


    // Single File View Get or Fetch
        /**
     * Retrieve all uploaded files for a specific requirement.
     *
     * @param  int  $sharedClearanceId
     * @param  int  $requirementId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUploadedFiles($sharedClearanceId, $requirementId)
    {
        $user = Auth::user();
    
        try {
            $uploadedFiles = UploadedClearance::where('shared_clearance_id', $sharedClearanceId)
                ->where('requirement_id', $requirementId)
                ->where('user_id', $user->id)
                ->where('is_archived', false)
                ->get();
    
            $files = $uploadedFiles->map(function($file) {
                return [
                    'id' => $file->id,
                    'name' => basename($file->file_path),
                    'file_path' => $file->file_path,  // Changed from url to file_path
                ];
            });
    
            return response()->json([
                'success' => true,
                'files' => $files,
            ]);
        } catch (\Exception $e) {
            Log::error('Fetching Uploaded Files Error: '.$e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch uploaded files.',
            ], 500);
        }
    }

    /////////////////////////////////////////// Generate Clearance Checklist Faculty ///////////////////////////////////////////

    public function generateChecklistInfo($id)
    {
        $clearance = Clearance::with('requirements')->find($id);
        $user = Auth::user(); // Get the authenticated user
    
        if (!$clearance) {
            return redirect()->back()->with('error', 'Clearance not found.');
        }
    
        // Get the compliance status for each requirement
        $requirements = $clearance->requirements->map(function ($requirement) use ($user, $clearance) {
            $uploadedFiles = UploadedClearance::where('requirement_id', $requirement->id)
                ->where('user_id', $user->id)
                ->where('shared_clearance_id', $clearance->id)
                ->where('is_archived', false)
                ->get();
    
            $feedback = $requirement->feedback->where('user_id', $user->id)->first();
    
            $status = 'Not Complied';
            if ($feedback && $feedback->signature_status == 'Complied') {
                $status = 'Complied';
            } elseif ($feedback && $feedback->signature_status == 'Resubmit') {
                $status = 'Resubmit';
            } elseif ($feedback && $feedback->signature_status == 'Not Applicable') {
                $status = 'Not Applicable';
            }
    
            return [
                'requirement' => $requirement,
                'status' => $status,
            ];
        });
    
        $department = $user->department ? $user->department->name : 'N/A';
        $program = $user->program ? $user->program->name : 'N/A';
        $lastClearanceUpdate = $user->last_clearance_update ? $user->last_clearance_update->format('F j, Y') : 'N/A';
    
        $pdf = PDF::loadView('faculty.views.reports.generate-checklist', compact('clearance', 'requirements', 'user', 'department', 'program', 'lastClearanceUpdate'));
        return $pdf->stream('clearance_' . $clearance->id . '_' . $clearance->document_name . '.pdf');
    }
}
