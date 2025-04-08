<?php

namespace App\Console\Commands;

use App\Models\StudentAttendance;
use Illuminate\Console\Command;

class CleanupAttendanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:cleanup {user_id? : The ID of the user to clean up records for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up duplicate attendance records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

        if ($userId) {
            $this->info("Cleaning up duplicate attendance records for user ID: {$userId}");
        } else {
            $this->info("Cleaning up duplicate attendance records for all users");
        }

        $count = StudentAttendance::cleanupDuplicateRecords($userId);

        if ($count > 0) {
            $this->info("Successfully removed {$count} duplicate attendance records.");
        } else {
            $this->info("No duplicate attendance records found.");
        }

        return 0;
    }
}
