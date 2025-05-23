<?php

namespace App\Console\Commands;

use App\Models\AuditTrail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupDuplicateAuditTrailEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit-trail:cleanup-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup duplicate login and logout entries in the audit trail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of duplicate audit trail entries...');

        // Get all users with login entries
        $users = AuditTrail::where('action_type', 'login')
            ->select('user_id')
            ->distinct()
            ->get();

        $totalDuplicatesRemoved = 0;

        foreach ($users as $user) {
            $userId = $user->user_id;
            $this->info("Processing user ID: {$userId}");

            // Process login entries
            $this->cleanupDuplicatesForUser($userId, 'login');
            
            // Process logout entries
            $this->cleanupDuplicatesForUser($userId, 'logout');
        }

        $this->info("Cleanup completed. Total duplicates removed: {$totalDuplicatesRemoved}");
        
        return Command::SUCCESS;
    }

    /**
     * Cleanup duplicate entries for a specific user and action type
     */
    private function cleanupDuplicatesForUser($userId, $actionType)
    {
        // Group entries by date
        $entries = AuditTrail::where('user_id', $userId)
            ->where('action_type', $actionType)
            ->orderBy('created_at')
            ->get();

        $entriesByDate = [];
        foreach ($entries as $entry) {
            $date = $entry->created_at->format('Y-m-d');
            if (!isset($entriesByDate[$date])) {
                $entriesByDate[$date] = [];
            }
            $entriesByDate[$date][] = $entry;
        }

        $duplicatesRemoved = 0;

        // For each date, keep only the first entry and delete the rest
        foreach ($entriesByDate as $date => $dateEntries) {
            if (count($dateEntries) > 1) {
                // Keep the first entry
                $keepEntry = array_shift($dateEntries);
                
                // Delete the rest
                foreach ($dateEntries as $entry) {
                    $this->info("Removing duplicate {$actionType} entry ID: {$entry->id} for user ID: {$userId} on date: {$date}");
                    $entry->delete();
                    $duplicatesRemoved++;
                }
            }
        }

        $this->info("Removed {$duplicatesRemoved} duplicate {$actionType} entries for user ID: {$userId}");
        return $duplicatesRemoved;
    }
}
