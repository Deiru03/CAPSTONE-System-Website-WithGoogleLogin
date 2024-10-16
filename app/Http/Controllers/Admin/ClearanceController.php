<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\UserClearance;
use App\Models\Clearance;
use App\Models\ClearanceRequirement;
use App\Models\SharedClearance;
use App\Models\ClearanceFeedback;

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
        $query = $request->input('query');

        $userClearances = UserClearance::with(['sharedClearance.clearance.requirements', 'user', 'uploadedClearances'])
            ->whereHas('sharedClearance.clearance.requirements', function ($q) use ($query) {
                $q->where('requirement', 'like', '%' . $query . '%');
            })
            ->get();

        return view('admin.views.clearances.clearance-check', compact('userClearances', 'query'));
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

        return response()->json([
            'success' => true,
            'message' => 'Clearance deleted successfully.'
        ]);
    }

    ///////////////////////////////////////// Clearance Requirements ///////////////////////////////////////
    public function showUserClearance($id)
    {
        $userClearance = UserClearance::with([
            'sharedClearance.clearance.requirements',
            'uploadedClearances.requirement.feedback',
            'user' // Added to include user data
        ])->findOrFail($id);
        return view('admin.views.clearances.user-clearance-details', compact('userClearance'));
    }
    
    public function checkClearances()
    {
        $userClearances = UserClearance::with(['sharedClearance.clearance', 'user'])->get();
        return view('admin.views.clearances.clearance-check', compact('userClearances'));
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
            'requirement' => 'required|string|max:255',
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
    
        $feedback = ClearanceFeedback::updateOrCreate(
            [
                'requirement_id' => $validatedData['requirement_id'],
                'user_id' => $validatedData['user_id'],
            ],
            [
                'message' => $validatedData['message'],
                'signature_status' => $validatedData['signature_status'],
            ]
        );
    
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
            'requirement' => 'required|string|max:255',
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

        return response()->json([
            'success' => true,
            'message' => 'Shared clearance removed successfully.',
        ]);
    }
}
