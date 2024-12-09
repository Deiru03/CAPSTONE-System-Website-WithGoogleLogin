<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Models\SubmittedReport;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Program;
use App\Models\Department;

class GenerateReports extends Controller
{
    public function showReportForm(): View
    {
        return view('admin.views.submitted-reports');
    }

    // Generate submitted reports
    public function generateSubmittedReport(Request $request)
    {
        $user = Auth::user();

        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg'))); //working

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Get all submitted reports between dates, regardless of user type/campus
        $query = SubmittedReport::with(['user', 'admin'])
            ->whereBetween('created_at', [$request->start_date, $request->end_date]);

        // Only apply filters if user is not a super admin
        if (!($user->user_type === 'Admin' && !$user->campus_id)) {
            if ($user->user_type === 'Admin') {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('campus_id', $user->campus_id);
                });
            } elseif ($user->user_type === 'Program-Head') {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('program_id', $user->program_id);
                });
            } elseif ($user->user_type === 'Dean') {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('department_id', $user->department_id);
                });
            }
        }

        SubmittedReport::create([
            'user_id' => $user->id,
            'admin_id' => $user->id,
            'title' => Auth::user()->name . ' Generated a Report from ' . $request->start_date . ' to ' . $request->end_date,
            'transaction_type' => 'Generate Report',
            'status' => null,
        ]);

        $reports = $query->get();

        $pdf = PDF::loadView('admin.views.reports.admin-submitted-reports', compact('reports', 'user', 'omscLogo', 'iqaLogo'));
        return $pdf->stream(now()->format('Y-m-d') . $user->name . '_submitted_reports.pdf');
    }

    // Export user reports
    public function exportUserReports($userId)
    {
        $user = User::findOrFail($userId);
        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png')));
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg')));

        // Filter reports for the specific user
        $reports = SubmittedReport::with(['user', 'admin'])
            ->where('user_id', $userId)
            ->get();

        // Reuse the existing view
        $pdf = PDF::loadView('admin.views.reports.admin-submitted-reports', compact('reports', 'user', 'omscLogo', 'iqaLogo'));
        return $pdf->stream($user->name . '_submitted_reports.pdf');
    }
}
