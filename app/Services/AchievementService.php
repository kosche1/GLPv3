<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\UserDailyReward;
use Carbon\Carbon;
use LevelUp\Experience\Models\Achievement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Services\NotificationService;

class AchievementService
{
    /**
     * Whether to track awarded achievements in the session
     *
     * @var bool
     */
    private bool $trackInSession = true;

    /**
     * The notification service instance.
     *
     * @var NotificationService
     */
    private NotificationService $notificationService;

    /**
     * Create a new achievement service instance.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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
        try {
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

            // Log the current level for debugging
            $achievementCount = Achievement::whereHas('users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->count();
            Log::info("User {$user->id} is level {$currentLevel} and has {$achievementCount} achievements");
        } catch (\Exception $e) {
            Log::error("Error in checkLevelAchievements: {$e->getMessage()}");
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
        // Instead of checking by category (which doesn't exist), check by trigger_type
        $triggerTypes = Badge::select('trigger_type')->distinct()->pluck('trigger_type');
        foreach ($triggerTypes as $triggerType) {
            if (!$triggerType) continue; // Skip null or empty trigger types

            $totalBadgesOfType = Badge::where('trigger_type', $triggerType)->count();
            // Count user badges of this type
            $userBadgesOfType = $user->badges()
                ->whereRaw("badges.trigger_type = ?", [$triggerType])
                ->count();

            if ($totalBadgesOfType > 0 && $userBadgesOfType === $totalBadgesOfType) {
                $this->awardAchievementByName($user, 'Badge Perfectionist');
                break; // Award once if any type is complete
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
        try {
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

            // Try to check for weekend warrior achievement
            try {
                // Using database-agnostic approach with Carbon
                $weekendLogins = UserDailyReward::where('user_id', $user->id)
                    ->get()
                    ->filter(function($login) {
                        $date = Carbon::parse($login->streak_date);
                        return $date->isWeekend(); // Carbon's isWeekend() checks if it's Saturday or Sunday
                    })
                    ->sortByDesc('streak_date');

                // Count consecutive weekends (need at least 1 login per weekend)
                $consecutiveWeekends = $this->countConsecutiveWeekends($weekendLogins);
                if ($consecutiveWeekends >= 10) {
                    $this->awardAchievementByName($user, 'Weekend Warrior');
                }
            } catch (\Exception $e) {
                Log::warning("Error checking weekend warrior achievement: {$e->getMessage()}");
            }

            // Try to check for time-based achievements
            try {
                // Using database-agnostic approach with Carbon
                $earlyMorningLogins = UserDailyReward::where('user_id', $user->id)
                    ->get()
                    ->filter(function($login) {
                        $hour = Carbon::parse($login->claimed_at)->hour;
                        return $hour < 6;
                    })
                    ->count();

                if ($earlyMorningLogins >= 5) {
                    $this->awardAchievementByName($user, 'Early Bird');
                }

                $lateNightLogins = UserDailyReward::where('user_id', $user->id)
                    ->get()
                    ->filter(function($login) {
                        $hour = Carbon::parse($login->claimed_at)->hour;
                        return $hour >= 23;
                    })
                    ->count();

                if ($lateNightLogins >= 5) {
                    $this->awardAchievementByName($user, 'Night Owl');
                }
            } catch (\Exception $e) {
                Log::warning("Error checking time-based achievements: {$e->getMessage()}");
            }
        } catch (\Exception $e) {
            Log::error("Error in checkLoginStreakAchievements: {$e->getMessage()}");
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
            $existingAchievement = $user->achievements()
                ->where('achievements.id', $achievement->id)
                ->first();

            if ($existingAchievement) {
                return; // User already has this achievement
            }

            // Award the achievement to the user
            try {
                // Try to use the grantAchievement method from the HasAchievements trait
                if (method_exists($user, 'grantAchievement')) {
                    $user->grantAchievement($achievement);
                } else {
                    // Fallback to manually attaching the achievement
                    $user->achievements()->attach($achievement->id, [
                        'unlocked_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } catch (\Exception $e) {
                // If there's an error with the unlocked_at column, try without it
                if (str_contains($e->getMessage(), 'unlocked_at')) {
                    $user->achievements()->attach($achievement->id, [
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    throw $e;
                }
            }

            // Add to session for notification (only if session tracking is enabled)
            if ($this->trackInSession) {
                $recentAchievements = Session::get('recent_achievements', []);
                $recentAchievements[] = $achievement->name;
                Session::put('recent_achievements', $recentAchievements);
            }

            // Create a notification for the achievement
            $this->notificationService->achievementNotification(
                $user,
                $achievement->name,
                route('profile') // Link to profile page where achievements are displayed
            );

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