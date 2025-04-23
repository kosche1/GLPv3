<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use App\Services\AchievementService;
use App\Services\ActivityService;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use LevelUp\Experience\Models\Achievement;

class DashboardController extends Controller
{
    protected $badgeService;
    protected $achievementService;
    protected $activityService;

    public function __construct(
        BadgeService $badgeService,
        AchievementService $achievementService,
        ActivityService $activityService
    ) {
        $this->badgeService = $badgeService;
        $this->achievementService = $achievementService;
        $this->activityService = $activityService;
    }

    /**
     * Display the dashboard or redirect based on user role.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        // Redirect faculty users to the teacher dashboard
        if (method_exists($user, 'hasRole') && $user->hasRole('faculty')) {
            return redirect('/teacher');
        }

        // Check and award achievements based on level, badges, and login streaks - not cached as this needs to run each time
        $this->achievementService->checkAllAchievements($user);

        // Check and award level-based badges - not cached as this needs to run each time
        $this->badgeService->checkAndAwardLevelBadges($user);

        // Get user badges with caching (30 second cache)
        $userBadges = Cache::remember('user_badges_'.$user->id, 30, function () use ($user) {
            return $this->badgeService->getUserBadges($user);
        });

        // Get user achievements with caching (30 second cache)
        $userAchievements = Cache::remember('user_achievements_'.$user->id, 30, function () use ($user) {
            $achievements = $user->achievements;

            // Log for debugging
            Log::info("User {$user->id} has " . ($achievements ? $achievements->count() : 0) . " achievements");

            if (!$achievements || $achievements->isEmpty()) {
                // Force check level achievements again
                $this->achievementService->checkLevelAchievements($user);
                // Get updated achievements
                $achievements = Achievement::whereHas('users', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                })->get();
                Log::info("After force check: User {$user->id} has " . ($achievements ? $achievements->count() : 0) . " achievements");
            }

            return $achievements;
        });

        // Clear dashboard cache to ensure fresh data
        Cache::forget('dashboard_data_'.$user->id);

        // Cache dashboard data for better performance (5 second cache)
        $dashboardData = Cache::remember('dashboard_data_'.$user->id, 5, function () use ($user) {
            return [
                'currentLevel' => $user->getLevel(),
                'currentPoints' => $user->getPoints(),
                // Other dashboard data that's expensive to calculate could be added here
            ];
        });

        // Get filter parameters from request
        $activityType = request()->get('activity_type', 'all');
        $timeRange = request()->get('time_range', 6); // Default to 6 months

        // Get user activity data
        $activityData = $this->activityService->getUserActivityData($user->id, $timeRange, $activityType);

        // Get user activity goals
        $activityGoals = $this->activityService->getUserActivityGoals($user->id);

        // Add goals to activity data
        $activityData['activity_goals'] = $activityGoals;

        // Generate activity graph HTML
        $activityGraphHtml = $this->activityService->generateActivityGraphHtml($activityData);

        // Generate trend indicator HTML
        $trendIndicatorHtml = $this->activityService->generateTrendIndicatorHtml($activityData);

        // Generate activity goals HTML (for use in combined HTML)
        $activityGoalsHtml = $this->activityService->generateActivityGoalsHtml($activityData);

        // Generate weekly summary HTML with integrated activity goals
        $weeklySummaryHtml = $this->activityService->generateWeeklySummaryHtml($activityData, $activityGoalsHtml);

        // Get current login streak
        $currentLoginStreak = StudentAttendance::getCurrentLoginStreak($user->id);

        // Available time ranges for the dropdown
        $timeRanges = [
            3 => '3 Months',
            6 => '6 Months',
            9 => '9 Months',
            12 => '1 Year',
        ];

        return view('dashboard', array_merge([
            'userBadges' => $userBadges,
            'userAchievements' => $userAchievements,
            'activityGraphHtml' => $activityGraphHtml,
            'weeklySummaryHtml' => $weeklySummaryHtml,
            'trendIndicatorHtml' => $trendIndicatorHtml,
            'currentLoginStreak' => $currentLoginStreak,
            'timeRanges' => $timeRanges,
            'selectedTimeRange' => $timeRange,
            'selectedActivityType' => $activityType
        ], $dashboardData));
    }
}