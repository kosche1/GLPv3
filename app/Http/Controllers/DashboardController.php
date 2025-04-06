<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
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
        if ($user->hasRole('faculty')) {
            return redirect('/teacher');
        }

        // Check and award level-based badges
        $this->badgeService->checkAndAwardLevelBadges($user);

        // Get user badges
        $userBadges = $this->badgeService->getUserBadges($user);

        return view('dashboard', [
            'userBadges' => $userBadges
        ]);
    }
}