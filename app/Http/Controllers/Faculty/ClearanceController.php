<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SharedClearance;
use App\Models\UploadedClearance;
use App\Models\UserClearance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClearanceController extends Controller
{/**
     * Display a listing of shared clearances for the faculty.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all shared clearances with their associated clearance data
        $sharedClearances = SharedClearance::with('clearance')->get();

        // Get user_clearances to map shared_clearance_id to user_clearance_id
        $userClearances = UserClearance::where('user_id', $user->id)
            ->whereIn('shared_clearance_id', $sharedClearances->pluck('id'))
            ->pluck('id', 'shared_clearance_id')
            ->toArray();

        // Determine recommendations based on user's units and position
        $recommendations = $sharedClearances->filter(function ($sharedClearance) use ($user) {
            return $sharedClearance->clearance->units == $user->units && $sharedClearance->clearance->type == $user->position;
        });

        return view('faculty.views.clearances.clearance-index', compact('sharedClearances', 'userClearances', 'recommendations'));
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

        // Create a new user clearance
        UserClearance::create([
            'shared_clearance_id' => $id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('faculty.clearances.index')->with('success', 'Clearance copied successfully.');
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

        // Confirm that the user has copied this clearance
        $userClearance = UserClearance::where('id', $id)
            ->where('user_id', $user->id)
            ->with('sharedClearance.clearance.requirements')
            ->firstOrFail();

        // Fetch already uploaded clearances by the user for this shared clearance
        $uploadedClearances = UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
            ->where('user_id', $user->id)
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
            'files.*' => 'required|file|mimes:pdf,doc,docx,jpg,png', // Allow multiple files
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle the file uploads
        if ($request->hasFile('files')) {
            try {
                foreach ($request->file('files') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('uploads/faculty_clearances', $originalName, 'public');

                    // Create a new UploadedClearance record for each file
                    UploadedClearance::create([
                        'shared_clearance_id' => $sharedClearanceId,
                        'requirement_id' => $requirementId,
                        'user_id' => $user->id,
                        'file_path' => $path,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Files uploaded successfully.',
                ]);
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('File Upload Error: '.$e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload files.',
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No files uploaded.',
        ], 400);
    }
    

    public function deleteFile($sharedClearanceId, $requirementId)
    {
        $user = Auth::user();

        try {
            // Retrieve the UploadedClearance record
            $uploadedClearance = UploadedClearance::where('shared_clearance_id', $sharedClearanceId)
                ->where('requirement_id', $requirementId)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Delete the file from storage
            if (Storage::disk('public')->exists($uploadedClearance->file_path)) {
                Storage::disk('public')->delete($uploadedClearance->file_path);
            }

            // Delete the record from the database
            $uploadedClearance->delete();

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('File Deletion Error: '.$e->getMessage());

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
                ->get();

            $files = $uploadedFiles->map(function($file) {
                return [
                    'id' => $file->id,
                    'name' => basename($file->file_path),
                    'url' => Storage::url($file->file_path),
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

        // Single File Delete
        /**
     * Delete a specific uploaded clearance file.
     *
     * @param  int  $sharedClearanceId
     * @param  int  $requirementId
     * @param  int  $fileId
     * @return \Illuminate\Http\JsonResponse
     */
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

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Deleting Single File Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the file.',
            ], 500);
        }
    }
}
