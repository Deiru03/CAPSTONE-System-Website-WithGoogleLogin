<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UploadedClearance;
use App\Models\UserClearance;
use App\Models\SubmittedReport;
use App\Models\ClearanceFeedback;
use App\Models\Program;
use Barryvdh\DomPDF\Facade\Pdf;

class FacultyController extends Controller
{

    //////////////////////////////////////////////// Views Controller ////////////////////////////////////////////////  

    public function home(): View
    {
        return view('faculty.home');
    }

    public function dashboard(): View
    {
        $user = Auth::user();
        $showProfileModal = empty($user->program_id) || empty($user->department_id) || empty($user->position);

        // Fetch the user's current active clearance data
        $userClearance = UserClearance::with(['sharedClearance.clearance.requirements', 'uploadedClearances'])
            ->where('user_id', $user->id)
            ->where('is_active', true) // Ensure only active clearance is fetched
            ->first();

        $noActiveClearance = !$userClearance;

        $userFeedbackReturn = ClearanceFeedback::where('user_id', $user->id)
            ->where('signature_status', 'return')
            ->count();

        $totalRequirements = 0;
        $uploadedRequirements = 0;
        $missingRequirements = 0;
        $returnedDocuments = 0;
        $completionRate = 0; // Initialize completion rate

        if ($userClearance) {
            $totalRequirements = $userClearance->sharedClearance->clearance->requirements->count();

            // Filter uploaded clearances to only include those for the current active clearance
            $currentUploadedClearances = UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
                ->where('user_id', $user->id)
                ->where('is_archived', false)
                ->get();

            $uploadedRequirements = $currentUploadedClearances->unique('requirement_id')->count();
            $missingRequirements = $totalRequirements - $uploadedRequirements;
            $returnedDocuments = ClearanceFeedback::whereIn('requirement_id', $currentUploadedClearances->pluck('requirement_id'))
                ->where('user_id', $user->id)
                ->where('signature_status', 'return')
                ->count();

            // Calculate completion rate
            if ($totalRequirements > 0) {
                $completionRate = ($uploadedRequirements / $totalRequirements) * 100;
                $completionRate = number_format($completionRate, 2); // Format to two decimal places
            }
        }

        return view('dashboard', compact(
            'showProfileModal',
            'noActiveClearance',
            'totalRequirements',
            'uploadedRequirements',
            'missingRequirements',
            'returnedDocuments',
            'userFeedbackReturn',
            'completionRate' // Pass formatted completion rate to the view
        ));
    }
    public function clearances(): View
    {
            // Fetch the user clearance data
        $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', Auth::id())->first();

        $userInfo = Auth::user();

        return view('faculty.views.clearances', compact('userClearance', 'userInfo'));
    }

    public function myFiles(): View
    {
        $user = Auth::user();

        // Fetch all uploaded clearances for the authenticated user
        $uploadedFiles = UploadedClearance::where('user_id', $user->id)
            ->with('requirement')
            ->where('is_archived', false)
            ->select('id', 'shared_clearance_id', 'requirement_id', 'user_id', 'file_path', 'created_at', 'updated_at')
            ->get();

        return view('faculty.views.my-files', compact('uploadedFiles'));
    }

    public function submittedReports(): View
    {
        $reports = SubmittedReport::where('user_id', Auth::id())
        ->get();

        return view('faculty.views.submitted-reports', compact('reports'));
    }
    
    public function archive(): View
    {
        $user = Auth::user();
        $archivedClearances = UploadedClearance::where('user_id', $user->id)
            ->where('is_archived', true)
            ->with('requirement')
            ->get();

        return view('faculty.views.archive', compact('archivedClearances'));
    }

    public function test(): View
    {
        return view('faculty.views.test-page');
    }       
    
/////////////////////////////////////////////// End of Views Controller ////////////////////////////////////////////////  

/////////////////////////////////////////////// PDF Controller or Generating slip PDF //////////////////////////////////////////////////  
    public function generateClearanceReport()
    {
        $user = Auth::user();
    
        // Fetch program name using the same logic we used before
        $user->program_name = Program::find($user->program_id)->name ?? 'N/A';
        
        $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', $user->id)->first();

        $pdf = Pdf::loadView('faculty.views.reports.clearance', compact('user', 'userClearance'));

        SubmittedReport::create([
            'admin_id' => null,
            'user_id' => Auth::id(),
            'title' => 'Generated Clearance Completion Slip',
            'transaction_type' => 'Slip Generated',
            'status' => 'Completed',
        ]);

        return $pdf->download('clearance-report.pdf');
    }
}
