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
use Illuminate\Support\Facades\Log;
use App\Models\Clearance;
use App\Models\SharedClearance;
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
            ->where('signature_status', 'resubmit')
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
                ->where('signature_status', 'resubmit')
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
        $reports = SubmittedReport::with('admin')
            ->where('user_id', Auth::id())
            ->get();

        return view('faculty.views.history-reports', compact('reports'));
    }

    public function archive(Request $request): View
    {
        $user = Auth::user();
        $sortOrder = $request->get('sort', 'desc'); // Default to newest
        $search = $request->get('search', '');

        $archivedClearances = UploadedClearance::where('user_id', $user->id)
            ->where('is_archived', true)
            ->where('file_path', 'like', "%{$search}%") // Search by file path
            ->orderBy('academic_year', $sortOrder)
            ->orderBy('semester', $sortOrder)
            ->orderBy('updated_at', $sortOrder)
            ->get();

        return view('faculty.views.archive', compact('archivedClearances', 'sortOrder', 'search'));
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

        $image = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        // $image = asset('images/OMSCLogo.png'); //not working
        // Fetch program name using the same logic we used before
        $user->program_name = Program::find($user->program_id)->name ?? 'N/A';

        $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', $user->id)->first();

        $pdf = Pdf::loadView('faculty.views.reports.clearance-slip', compact('user', 'userClearance', 'image'));

        SubmittedReport::create([
            'admin_id' => null,
            'user_id' => Auth::id(),
            'title' => 'Generated Clearance Completion Slip',
            'transaction_type' => 'Slip Generated',
            'status' => 'Completed',
        ]);

        return $pdf->download('clearance-report.pdf');
    }

    public function generateChecklist($id)
    {
        // Debugging: Log the ID being used
        Log::info('Generating checklist for clearance ID: ' . $id);

        $clearance = Clearance::with('requirements')->find($id);
        $sharedClearance = SharedClearance::with('clearance')->find($id);

        // Debugging: Check if clearance is found
        if (!$sharedClearance || !$sharedClearance->clearance) {
            return redirect()->back()->with('error', 'Clearance not found.');
        }
        $clearance = $sharedClearance->clearance;
        $user = Auth::user();

        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg'))); //working

        // Fetch requirements and their statuses
        $requirements = $clearance->requirements->map(function ($requirement) use ($user, $clearance) {
            $uploadedFiles = UploadedClearance::where('requirement_id', $requirement->id)
                ->where('user_id', $user->id)
                ->where('shared_clearance_id', $clearance->id)
                ->where('is_archived', false)
                ->get();

            $feedback = $requirement->feedback->where('user_id', $user->id)->first();

            $status = 'Not Complied';
            if ($uploadedFiles->isNotEmpty()) {
                $status = 'Complied';
            } elseif ($feedback && $feedback->signature_status == 'Resubmit') {
                $status = 'Resubmit';
            } elseif ($feedback && $feedback->signature_status == 'Complied') {
                $status = 'Complied';
            } elseif ($feedback && $feedback->signature_status == 'Checking') {
                $status = 'Not Complied';
            } elseif ($feedback && $feedback->signature_status == 'Not Applicable') {
                $status = 'Not Applicable';
            }

            return [
                'requirement' => $requirement,
                'status' => $status,
            ];
        });

        $department = $user->department ? $user->department->name : 'N/A';
        $program = User::find($user->program);
        $lastClearanceUpdate = $user->last_clearance_update ? $user->last_clearance_update->format('F j, Y') : 'N/A';

        $pdf = PDF::loadView('faculty.views.reports.generate-checklist', compact('clearance', 'omscLogo', 'iqaLogo', 'requirements', 'user', 'department', 'program', 'lastClearanceUpdate'))
            ->setPaper('legal', 'portrait');
        return $pdf->stream('clearance_' . $clearance->id . '_' . $clearance->document_name . '.pdf');
    }
}
