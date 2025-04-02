<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\UserDailyReward;
use Carbon\Carbon;
use LevelUp\Experience\Models\Achievement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AchievementService
{
    /**
     * Whether to track awarded achievements in the session
     *
     * @var bool
     */
    private bool $trackInSession = true;
    
    /**
     * Disable tracking achievements in session (for bulk operations)
     * 
     * @return void
     */
    public function disableSessionTracking(): void
    {
        $this->trackInSession = false;
    }
    
    /**
     * Enable tracking achievements in session
     * 
     * @return void
     */
    public function enableSessionTracking(): void
    {
        $this->trackInSession = true;
    }
    
    /**
     * Check if user has earned any level-based achievements
     *
     * @param User $user
     * @return void
     */
    public function checkLevelAchievements(User $user): void
    {
        // Get the user's current level
        $currentLevel = $user->getLevel();
        
        // Map of level milestones to achievement names
        $levelAchievements = [
            5 => 'Getting Started',
            10 => 'Intermediate Learner',
            15 => 'Level Milestone: 15', // Secret achievement
            25 => 'Advanced Scholar',
            30 => 'Level Milestone: 30', // Secret achievement
            50 => 'Master of Knowledge',
        ];
        
        // Check if user has earned any level-based achievements
        foreach ($levelAchievements as $level => $achievementName) {
            if ($currentLevel >= $level) {
                $this->awardAchievementByName($user, $achievementName);
            }
        }
    }
    
    /**
     * Check if user has earned any badge collection achievements
     *
     * @param User $user
     * @return void
     */
    public function checkBadgeCollectionAchievements(User $user): void
    {
        // Get the count of unique badges the user has
        $badgeCount = $user->badges()->count();
        
        // Map of badge count milestones to achievement names
        $badgeAchievements = [
            5 => 'Badge Collector',
            15 => 'Badge Enthusiast',
            30 => 'Badge Connoisseur',
        ];
        
        // Check if user has earned any badge collection achievements
        foreach ($badgeAchievements as $count => $achievementName) {
            if ($badgeCount >= $count) {
                $this->awardAchievementByName($user, $achievementName);
            }
        }
        
        // Check for badge perfectionist (secret achievement)
        // This assumes badges are organized by categories
        // We need to check if the user has all badges in any category
        $categories = Badge::select('category')->distinct()->pluck('category');
        foreach ($categories as $category) {
            $totalBadgesInCategory = Badge::where('category', $category)->count();
            $userBadgesInCategory = $user->badges()
                ->whereHas('badge', function ($query) use ($category) {
                    $query->where('category', $category);
                })
                ->count();
                
            if ($totalBadgesInCategory > 0 && $userBadgesInCategory === $totalBadgesInCategory) {
                $this->awardAchievementByName($user, 'Badge Perfectionist');
                break; // Award once if any category is complete
            }
        }
    }
    
    /**
     * Check if user has earned any login streak achievements
     *
     * @param User $user
     * @return void
     */
    public function checkLoginStreakAchievements(User $user): void
    {
        // Get the user's login streak from UserDailyReward
        $latestStreak = UserDailyReward::where('user_id', $user->id)
            ->orderBy('claimed_at', 'desc')
            ->first();
            
        if (!$latestStreak) {
            return;
        }
        
        $currentStreak = $latestStreak->current_streak;
        
        // Map of streak milestones to achievement names
        $streakAchievements = [
            7 => 'First Week',
            30 => 'Dedicated Learner',
            100 => 'Consistent Scholar',
            365 => 'Learning Lifestyle',
        ];
        
        // Check if user has earned any streak-based achievements
        foreach ($streakAchievements as $days => $achievementName) {
            if ($currentStreak >= $days) {
                $this->awardAchievementByName($user, $achievementName);
            }
        }
        
        // Check for weekend warrior (secret achievement)
        // Count consecutive weekend logins
        $weekendLogins = UserDailyReward::where('user_id', $user->id)
            ->whereRaw("DAYOFWEEK(streak_date) IN (1, 7)") // 1 = Sunday, 7 = Saturday in MySQL
            ->orderBy('streak_date', 'desc')
            ->get();
            
        // Count consecutive weekends (need at least 1 login per weekend)
        $consecutiveWeekends = $this->countConsecutiveWeekends($weekendLogins);
        if ($consecutiveWeekends >= 10) {
            $this->awardAchievementByName($user, 'Weekend Warrior');
        }
        
        // Check for time-based achievements (early bird, night owl)
        $earlyMorningLogins = UserDailyReward::where('user_id', $user->id)
            ->whereRaw("HOUR(claimed_at) < 6")
            ->count();
            
        if ($earlyMorningLogins >= 5) {
            $this->awardAchievementByName($user, 'Early Bird');
        }
        
        $lateNightLogins = UserDailyReward::where('user_id', $user->id)
            ->whereRaw("HOUR(claimed_at) >= 23")
            ->count();
            
        if ($lateNightLogins >= 5) {
            $this->awardAchievementByName($user, 'Night Owl');
        }
    }
    
    /**
     * Award an achievement to a user by achievement name
     *
     * @param User $user
     * @param string $achievementName
     * @return void
     */
    public function awardAchievementByName(User $user, string $achievementName): void
    {
        try {
            // Find the achievement by name
            $achievement = Achievement::where('name', $achievementName)->first();
            
            if (!$achievement) {
                Log::warning("Achievement not found: {$achievementName}");
                return;
            }
            
            // Check if the user already has this achievement
            $existingAchievement = $user->getUserAchievements()
                ->where('id', $achievement->id)
                ->first();
                
            if ($existingAchievement) {
                return; // User already has this achievement
            }
            
            // Award the achievement to the user
            $user->grantAchievement($achievement);
            
            // Add to session for notification (only if session tracking is enabled)
            if ($this->trackInSession) {
                $recentAchievements = Session::get('recent_achievements', []);
                $recentAchievements[] = $achievement->name;
                Session::put('recent_achievements', $recentAchievements);
            }
            
            Log::info("Achievement '{$achievementName}' awarded to user {$user->name}");
        } catch (\Exception $e) {
            Log::error("Error awarding achievement: {$e->getMessage()}");
        }
    }
    
    /**
     * Count consecutive weekends from login data
     *
     * @param \Illuminate\Support\Collection $weekendLogins
     * @return int
     */
    private function countConsecutiveWeekends($weekendLogins): int
    {
        if ($weekendLogins->isEmpty()) {
            return 0;
        }
        
        $consecutiveCount = 1;
        $maxConsecutive = 1;
        $weekendDates = [];
        
        // Group logins by weekend (considering Saturday and Sunday as one weekend)
        foreach ($weekendLogins as $login) {
            $date = Carbon::parse($login->streak_date);
            $weekNumber = $date->year . '-' . $date->weekOfYear;
            $weekendDates[$weekNumber] = true;
        }
        
        // Sort by week number
        ksort($weekendDates);
        $weeks = array_keys($weekendDates);
        
        // Count consecutive weekends
        for ($i = 1; $i < count($weeks); $i++) {
            $currentWeek = explode('-', $weeks[$i]);
            $previousWeek = explode('-', $weeks[$i-1]);
            
            // Check if weeks are consecutive
            if (
                ($currentWeek[0] == $previousWeek[0] && $currentWeek[1] == $previousWeek[1] + 1) ||
                ($currentWeek[0] == $previousWeek[0] + 1 && $previousWeek[1] == 52 && $currentWeek[1] == 1)
            ) {
                $consecutiveCount++;
                $maxConsecutive = max($maxConsecutive, $consecutiveCount);
            } else {
                $consecutiveCount = 1;
            }
        }
        
        return $maxConsecutive;
    }
    
    /**
     * Check all possible achievements for a user
     *
     * @param User $user
     * @return void
     */
    public function checkAllAchievements(User $user): void
    {
        $this->checkLevelAchievements($user);
        $this->checkBadgeCollectionAchievements($user);
        $this->checkLoginStreakAchievements($user);
    }
} 