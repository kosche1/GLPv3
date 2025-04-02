<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\AchievementService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckUserAchievements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-user-achievements {--user=} {--verbose}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and award achievements for all users or a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user');
        $verbose = $this->option('verbose');
        $achievementService = new AchievementService();

        if ($userId) {
            // Check for a specific user
            $user = User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return 1;
            }
            
            $this->checkAchievementsForUser($user, $achievementService, $verbose);
            $this->info("Achievement check completed for user {$user->name}");
        } else {
            // Process all users
            $userCount = User::count();
            $this->info("Checking achievements for {$userCount} users...");
            
            $progressBar = $this->output->createProgressBar($userCount);
            $progressBar->start();
            
            User::chunk(100, function ($users) use ($achievementService, $verbose, $progressBar) {
                foreach ($users as $user) {
                    $this->checkAchievementsForUser($user, $achievementService, $verbose);
                    $progressBar->advance();
                }
            });
            
            $progressBar->finish();
            $this->newLine();
            $this->info("Achievement check completed for all users.");
        }
        
        return 0;
    }
    
    /**
     * Check achievements for a specific user
     * 
     * @param User $user
     * @param AchievementService $achievementService
     * @param bool $verbose
     */
    private function checkAchievementsForUser(User $user, AchievementService $achievementService, bool $verbose): void
    {
        try {
            // Disable session tracking for bulk processing
            $achievementService->disableSessionTracking();
            
            // Run all achievement checks
            $achievementService->checkAllAchievements($user);
            
            if ($verbose) {
                $this->line("Checked achievements for user: {$user->name}");
            }
        } catch (\Exception $e) {
            $message = "Error checking achievements for user {$user->id}: {$e->getMessage()}";
            Log::error($message);
            if ($verbose) {
                $this->error($message);
            }
        }
    }
}
