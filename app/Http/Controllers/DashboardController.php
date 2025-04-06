<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        // Check and award achievements based on level, badges, and login streaks
        $this->achievementService->checkAllAchievements($user);

        // Check and award level-based badges
        $this->badgeService->checkAndAwardLevelBadges($user);

        // Get user badges
        $userBadges = $this->badgeService->getUserBadges($user);

        // Get user achievements
        $userAchievements = $user->achievements;

        // Log for debugging
        Log::info("User {$user->id} has " . ($userAchievements ? $userAchievements->count() : 0) . " achievements");

        if (!$userAchievements || $userAchievements->isEmpty()) {
            // Force check level achievements again
            $this->achievementService->checkLevelAchievements($user);
            // Get updated achievements
            $userAchievements = Achievement::whereHas('users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->get();
            Log::info("After force check: User {$user->id} has " . ($userAchievements ? $userAchievements->count() : 0) . " achievements");
        }

        return view('dashboard', [
            'userBadges' => $userBadges,
            'userAchievements' => $userAchievements
        ]);
    }
}