<?php

namespace Database\Seeders;

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

            // Admin users
            AdminSeeder::class,

            // Users
            ...(!env('USE_WORKOS', false) ? [UserSeeder::class] : []),

            // Gamification base data
            LevelSeeder::class,
            BadgeSeeder::class,
            AchievementSeeder::class,

            // Challenges are now handled by CoreSubjectsSeeder

            DailyRewardTierSeeder::class,
            RewardSeeder::class,
            ReferralProgramSeeder::class,

            // Categories and Leaderboard categories
            CategorySeeder::class,
            LeaderboardCategorySeeder::class,

            // Strands and Subject Types
            StrandAndSubjectTypeSeeder::class,

            // Core Subjects
            CoreSubjectsSeeder::class,

            // Applied Subjects
            AppliedSubjectsSeeder::class,

            // Specialized Subjects
            SpecializedSubjectsSeeder::class,

            // Specialized Track Subjects
            StemSubjectsSeeder::class,
            AbmSubjectsSeeder::class,
            HumssSubjectsSeeder::class,
            HeSubjectsSeeder::class,
            IctSubjectsSeeder::class,

            // Investment Challenges
            InvestmentChallengeSeeder::class,

            // ICT Computer Programming
            IctComputerProgrammingSeeder::class,

            // Forum categories
            ForumCategorySeeder::class,

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
            StudentGradeSeeder::class,
        ]);
    }
}
