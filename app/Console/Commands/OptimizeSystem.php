<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\SubmittedReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\UserNotification;

class OptimizeSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform system optimization tasks such as clearing cache and pruning old reports';

    protected function pruneOldReports()
    {
        $thresholdDate = Carbon::now()->subYears(10);
        $deletedReportsCount = SubmittedReport::where('created_at', '<', $thresholdDate)->delete();
        $this->info("Deleted {$deletedReportsCount} submitted reports older than 10 years.");
    }

    protected function deleteOldFiles()
    {
        $thresholdDate = Carbon::now()->subYears(5);
        $files = Storage::disk('public')->allFiles('uploads/faculty_clearances');
        $deletedFilesCount = 0;
        foreach ($files as $file) {
            $lastModified = Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file));
            if ($lastModified->lessThan($thresholdDate)) {
                Storage::disk('public')->delete($file);
                $deletedFilesCount++;
            }
        }
        $this->info("Deleted {$deletedFilesCount} files older than 5 years.");
    }

    protected function deleteOldNotifications()
    {
        $thresholdDate = Carbon::now()->subYears(5);
        $deletedNotificationsCount = UserNotification::where('created_at', '<', $thresholdDate)->delete();

        $this->info("Deleted {$deletedNotificationsCount} user notifications older than 5 years.");
    }

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     // Clear cache
    //     Artisan::call('cache:clear');
    //     $this->info('Cache cleared successfully.');

    //     // Prune old reports
    //     $count = SubmittedReport::count();

    //     if ($count > 0000000) {
    //         $toDelete = $count / 2;
    //         SubmittedReport::orderBy('created_at')->limit($toDelete)->delete();
    //         $this->info("Pruned {$toDelete} old submitted reports.");
    //     } else {
    //         $this->info('No pruning needed.');
    //     }
    // }
    public function handle()
    {
        // Clear cache
        Artisan::call('cache:clear');
        $this->info('Cache cleared successfully.');

        // Prune old reports
        $this->pruneOldReports();

        // Delete old files
        $this->deleteOldFiles();

        // Delete old notifications
        $this->deleteOldNotifications();
    }
}
