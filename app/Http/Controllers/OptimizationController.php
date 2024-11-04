<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\SubmittedReport;

class OptimizationController extends Controller
{
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return response()->json(['message' => 'Cache cleared successfully.']);
    }

    public function pruneReports()
    {
        $count = SubmittedReport::count();

        if ($count > 20000) {
            $toDelete = $count / 2;
            SubmittedReport::orderBy('created_at')->limit($toDelete)->delete();
            return response()->json(['message' => "Pruned {$toDelete} old submitted reports."]);
        }

        return response()->json(['message' => 'No pruning needed.']);
    }
}
