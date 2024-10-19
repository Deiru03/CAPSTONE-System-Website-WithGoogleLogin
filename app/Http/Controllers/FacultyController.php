<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UploadedClearance;
use App\Models\UserClearance;
use App\Models\SubmittedReport;

class FacultyController extends Controller
{

    //////////////////////////////////////////////// Views Controller ////////////////////////////////////////////////  
    public function dashboard(): View
    {
        $user = Auth::user();
        $showProfileModal = empty($user->program) || empty($user->position);

        // Fetch the user's clearance data
        $userClearance = UserClearance::with(['sharedClearance.clearance.requirements', 'uploadedClearances'])
            ->where('user_id', $user->id)
            ->first();

        $totalRequirements = 0;
        $uploadedRequirements = 0;
        $missingRequirements = 0;
        $returnedDocuments = 0;

        if ($userClearance) {
            $totalRequirements = $userClearance->sharedClearance->clearance->requirements->count();
            $uploadedRequirements = $userClearance->uploadedClearances->unique('requirement_id')->count();
            $missingRequirements = $totalRequirements - $uploadedRequirements;
            $returnedDocuments = $userClearance->uploadedClearances->where('status', 'returned')->count();
        }

        return view('dashboard', compact('showProfileModal', 'totalRequirements', 'uploadedRequirements', 'missingRequirements', 'returnedDocuments'));
    }
    public function clearances(): View
    {
            // Fetch the user clearance data
        $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', Auth::id())->first();

        return view('faculty.views.clearances', compact('userClearance'));
    }

    public function myFiles(): View
    {
        $user = Auth::user();

        // Fetch all uploaded clearances for the authenticated user
        $uploadedFiles = UploadedClearance::where('user_id', $user->id)
            ->with('requirement')
            ->select('id', 'shared_clearance_id', 'requirement_id', 'user_id', 'file_path', 'created_at', 'updated_at')
            ->get();

        return view('faculty.views.my-files', compact('uploadedFiles'));
    }

    public function submittedReports(): View
    {
        $reports = SubmittedReport::where('user_id', Auth::id())
            ->with(['requirement', 'uploadedClearance'])
            ->get();

        return view('faculty.views.submitted-reports', compact('reports'));
    }
    public function test(): View
    {
        return view('faculty.views.test-page');
    }       
    
/////////////////////////////////////////////// End of Views Controller ////////////////////////////////////////////////  
}
