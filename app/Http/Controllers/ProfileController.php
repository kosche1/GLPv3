<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();

        // Mock data for demonstration purposes
        $currentLevel = 5;
        $currentPoints = 1250;
        $progressPercentage = 60;

        // Mock recent activities
        $recentActivities = collect([
            [
                'description' => 'Completed PHP Basics course',
                'points_changed' => 100,
                'created_at' => now()->subDays(2),
            ],
            [
                'description' => 'Submitted assignment: Laravel Controllers',
                'points_changed' => 50,
                'created_at' => now()->subDays(5),
            ],
        ]);

        // Convert array items to objects
        $recentActivities = $recentActivities->map(function ($item) {
            return (object) $item;
        });

        // Mock achievements
        $achievements = collect([
            [
                'name' => 'First Steps',
                'description' => 'Completed your first course',
                'image' => null,
            ],
        ]);

        // Convert array items to objects
        $achievements = $achievements->map(function ($item) {
            return (object) $item;
        });

        // Mock badges
        $badges = collect([
            [
                'name' => 'PHP Enthusiast',
                'description' => 'Completed all PHP courses',
                'image' => null,
                'pivot' => (object) ['earned_at' => now()->subMonths(1)],
            ],
        ]);

        // Convert array items to objects
        $badges = $badges->map(function ($item) {
            $item['pivot'] = (object) $item['pivot'];
            return (object) $item;
        });

        // Mock statistics
        $forumPostsCount = 12;
        $enrolledCourses = 3;
        $completedChallenges = 2;

        // Mock learning progress
        $learningProgress = collect([
            [
                'name' => 'PHP Basics',
                'progress' => 75,
            ],
            [
                'name' => 'Laravel Fundamentals',
                'progress' => 30,
            ],
        ]);

        // Calculate profile completion
        $profileCompletion = $this->calculateProfileCompletion($user);

        return view('profile', compact(
            'user',
            'currentLevel',
            'currentPoints',
            'progressPercentage',
            'recentActivities',
            'achievements',
            'badges',
            'forumPostsCount',
            'enrolledCourses',
            'completedChallenges',
            'learningProgress',
            'profileCompletion'
        ));
    }

    /**
     * Calculate the user's profile completion percentage.
     */
    private function calculateProfileCompletion(User $user)
    {
        $completionItems = [
            'profile_picture' => !empty($user->avatar),
            'about_me' => !empty($user->bio) || true, // Mock data: assume bio exists
            'skills' => !empty($user->skills),
        ];

        $completedItems = count(array_filter($completionItems));
        $totalItems = count($completionItems);

        $percentage = ($totalItems > 0) ? round(($completedItems / $totalItems) * 100) : 0;

        return [
            'percentage' => $percentage,
            'items' => $completionItems,
        ];
    }
}
