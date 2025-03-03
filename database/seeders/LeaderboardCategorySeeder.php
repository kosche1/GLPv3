<?php

namespace Database\Seeders;

use App\Models\LeaderboardCategory;
use Illuminate\Database\Seeder;

class LeaderboardCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Points-based leaderboards
        LeaderboardCategory::create([
            'name' => 'Daily Points',
            'description' => 'Top users by points earned today',
            'metric' => 'points',
            'timeframe' => 'daily',
            'is_active' => true,
        ]);

        LeaderboardCategory::create([
            'name' => 'Weekly Points',
            'description' => 'Top users by points earned this week',
            'metric' => 'points',
            'timeframe' => 'weekly',
            'is_active' => true,
        ]);

        LeaderboardCategory::create([
            'name' => 'Monthly Points',
            'description' => 'Top users by points earned this month',
            'metric' => 'points',
            'timeframe' => 'monthly',
            'is_active' => true,
        ]);

        LeaderboardCategory::create([
            'name' => 'All-Time Points',
            'description' => 'Top users by total points earned',
            'metric' => 'points',
            'timeframe' => 'alltime',
            'is_active' => true,
        ]);

        // Task-based leaderboards
        LeaderboardCategory::create([
            'name' => 'Weekly Tasks',
            'description' => 'Top users by tasks completed this week',
            'metric' => 'tasks',
            'timeframe' => 'weekly',
            'is_active' => true,
        ]);

        // Streak-based leaderboards
        LeaderboardCategory::create([
            'name' => 'Longest Streaks',
            'description' => 'Users with the longest active streaks',
            'metric' => 'streaks',
            'timeframe' => 'alltime',
            'is_active' => true,
        ]);

        // Referral-based leaderboards
        LeaderboardCategory::create([
            'name' => 'Top Referrers',
            'description' => 'Users with the most referrals',
            'metric' => 'referrals',
            'timeframe' => 'alltime',
            'is_active' => true,
        ]);
    }
}
