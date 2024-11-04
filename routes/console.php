<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
// use App\Console\Commands\OptimizeSystem;
// use App\Models\SubmittedReport;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Artisan::command('app:optimize-system', function () {
//     // Clear cache
//     Artisan::call('cache:clear');
//     $this->info('Cache cleared successfully.');

//     // Prune old reports
//     $count = SubmittedReport::count();

//     if ($count > 20000) {
//         $toDelete = $count / 2;
//         SubmittedReport::orderBy('created_at')->limit($toDelete)->delete();
//         $this->info("Pruned {$toDelete} old submitted reports.");
//     } else {
//         $this->info('No pruning needed.');
//     }
// })->describe('Perform system optimization tasks');