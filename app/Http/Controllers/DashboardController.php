<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use LevelUp\Experience\Models\Achievement;

class DashboardController extends Controller
{
    protected $badgeService;
    protected $achievementService;

    public function __construct(BadgeService $badgeService, AchievementService $achievementService)
    {
        $this->badgeService = $badgeService;
        $this->achievementService = $achievementService;
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

        // Get user badges with caching (5 minute cache)
        $userBadges = Cache::remember('user_badges_'.$user->id, 300, function () use ($user) {
            return $this->badgeService->getUserBadges($user);
        });

        // Get user achievements with caching (5 minute cache)
        $userAchievements = Cache::remember('user_achievements_'.$user->id, 300, function () use ($user) {
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

        // Cache dashboard data for better performance
        $dashboardData = Cache::remember('dashboard_data_'.$user->id, 300, function () use ($user) {
            return [
                'currentLevel' => $user->getLevel(),
                'currentPoints' => $user->getPoints(),
                // Other dashboard data that's expensive to calculate could be added here
            ];
        });

        return view('dashboard', array_merge([
            'userBadges' => $userBadges,
            'userAchievements' => $userAchievements
        ], $dashboardData));
    }
}