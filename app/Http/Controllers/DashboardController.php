<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Check and award level-based badges
        $this->badgeService->checkAndAwardLevelBadges($user);

        // Get user badges
        $userBadges = $this->badgeService->getUserBadges($user);

        return view('dashboard', [
            'userBadges' => $userBadges
        ]);
    }
}