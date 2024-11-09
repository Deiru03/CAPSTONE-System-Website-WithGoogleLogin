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

class GenerateReports extends Controller
{
    public function showReportForm(): View
    {
        return view('admin.views.submitted-reports');
    }

    public function generateReport(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        $query = SubmittedReport::with(['user', 'admin'])
            ->whereBetween('created_at', [$request->start_date, $request->end_date]);
    
        // Filter based on user type
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

        SubmittedReport::create([
            'user_id' => $user->id,
            'admin_id' => $user->id,
            'title' => Auth::user()->name . ' Generated a Report from ' . $request->start_date . ' to ' . $request->end_date,
            'transaction_type' => 'Generate Report',
            'status' => null,
        ]);
    
        $reports = $query->get();
    
        $pdf = PDF::loadView('admin.views.reports.admin-submitted-reports', compact('reports', 'user'));
        return $pdf->download(now()->format('Y-m-d') . $user->name . '_submitted_reports.pdf');
    }
}