<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\SubmittedReport;

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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear cache
        Artisan::call('cache:clear');
        $this->info('Cache cleared successfully.');

        // Prune old reports
        $count = SubmittedReport::count();

        if ($count > 20000) {
            $toDelete = $count / 2;
            SubmittedReport::orderBy('created_at')->limit($toDelete)->delete();
            $this->info("Pruned {$toDelete} old submitted reports.");
        } else {
            $this->info('No pruning needed.');
        }
    }
}
