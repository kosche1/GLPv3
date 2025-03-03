<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in specific order to handle dependencies
        $this->call([
            // Core permissions and roles
            PermissionSeeder::class,
            RoleSeeder::class,

            // Users
            UserSeeder::class,

            // Gamification base data
            LevelSeeder::class,
            BadgeSeeder::class,
            TaskSeeder::class,
            DailyRewardTierSeeder::class,
            RewardSeeder::class,
            ReferralProgramSeeder::class,

            // Leaderboard categories
            LeaderboardCategorySeeder::class,

            // Streak activities
            StreakActivitySeeder::class,

            // Sample data for user achievements, tasks, etc.
            UserExperienceSeeder::class,
            UserBadgeSeeder::class,
            UserTaskSeeder::class,
            UserDailyRewardSeeder::class,
            UserStreakSeeder::class,
            ReferralSeeder::class,
            LeaderboardEntrySeeder::class,
        ]);
    }
}
