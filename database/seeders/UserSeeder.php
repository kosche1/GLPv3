<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Badge;
use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use LevelUp\Experience\Models\Achievement;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data first
        if (app()->environment() !== 'production') {
            // Reset related tables (safely)
            DB::table('achievement_user')->where('id', '>=', 1)->delete();
            DB::table('streaks')->where('id', '>=', 1)->delete();
            DB::table('streak_histories')->where('id', '>=', 1)->delete();
            DB::table('user_challenges')->where('id', '>=', 1)->delete();
            DB::table('experiences')->where('id', '>=', 1)->delete();
        }

        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');
        
        // Create basic experience record for admin if not exists and if applicable tables exist
        if (\Illuminate\Support\Facades\Schema::hasTable('levels') && \Illuminate\Support\Facades\Schema::hasTable('experiences')) {
            try {
                // Get level 1
                $level1 = DB::table('levels')->where('level', 1)->first();
                
                if ($level1) {
                    // Create experience record for admin to prevent null errors
                    DB::table('experiences')->updateOrInsert(
                        ['user_id' => $admin->id],
                        [
                            'level_id' => $level1->id,
                            'experience_points' => 0,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
                }
            } catch (\Exception $e) {
                // Silently fail if there's an issue - the error handling in the blade will take care of it
            }
        }

        // Create faculty users
        $faculty1 = User::updateOrCreate(
            ['email' => 'faculty1@example.com'],
            [
                'name' => 'Faculty One',
                'password' => Hash::make('password'),
            ]
        );
        $faculty1->assignRole('faculty');

        $faculty2 = User::updateOrCreate(
            ['email' => 'faculty2@example.com'],
            [
                'name' => 'Faculty Two',
                'password' => Hash::make('password'),
            ]
        );
        $faculty2->assignRole('faculty');

        // Create students with different progression levels for LevelUp examples

        // 1. BEGINNER STUDENT - Level 1-5, basic achievements, new streaks
        $beginner = User::updateOrCreate(
            ['email' => 'beginner@example.com'],
            [
                'name' => 'Beginner Student',
                'password' => Hash::make('password'),
                'points' => 200, // Direct points instead of using addPoints
            ]
        );
        $beginner->assignRole('student');
        
        // Grant a basic achievement with 100% progress
        $this->grantAchievement($beginner, 'Novice');
        
        // Start a streak (2 days)
        $this->createStreak($beginner, 'daily_login', 2);
        
        // Enroll in a basic challenge
        $this->enrollInChallenge($beginner, 'Beginner Python', 30);

        // 2. INTERMEDIATE STUDENT - Level 5-10, more achievements, longer streaks
        $intermediate = User::updateOrCreate(
            ['email' => 'intermediate@example.com'],
            [
                'name' => 'Intermediate Student',
                'password' => Hash::make('password'),
                'points' => 1700, // Direct points instead of using addPoints
            ]
        );
        $intermediate->assignRole('student');
        
        // Grant multiple achievements
        $this->grantAchievement($intermediate, 'Novice');
        $this->grantAchievement($intermediate, 'Journeyman');
        $this->grantAchievement($intermediate, 'Task Starter');
        $this->grantAchievement($intermediate, 'Consistent');
        
        // Achievement with partial progress (75%)
        $this->grantAchievement($intermediate, 'Task Master', 75);
        
        // Longer streak (14 days)
        $this->createStreak($intermediate, 'daily_login', 14);
        $this->createStreak($intermediate, 'task_completion', 7);
        
        // Enroll and progress in challenges
        $this->enrollInChallenge($intermediate, 'Intermediate Java', 80);
        $this->enrollInChallenge($intermediate, 'Web Development Basics', 100);

        // 3. ADVANCED STUDENT - High level, many achievements, long streaks, completed challenges
        $advanced = User::updateOrCreate(
            ['email' => 'advanced@example.com'],
            [
                'name' => 'Advanced Student',
                'password' => Hash::make('password'),
                'points' => 9500, // Direct points instead of using addPoints
            ]
        );
        $advanced->assignRole('student');
        
        // Grant many achievements
        $this->grantAchievement($advanced, 'Novice');
        $this->grantAchievement($advanced, 'Journeyman');
        $this->grantAchievement($advanced, 'Master');
        $this->grantAchievement($advanced, 'Task Starter');
        $this->grantAchievement($advanced, 'Task Master');
        $this->grantAchievement($advanced, 'Consistent');
        $this->grantAchievement($advanced, 'Dedicated');
        $this->grantAchievement($advanced, 'Influencer');
        
        // Secret achievement
        $this->grantAchievement($advanced, 'Mystery Solver');
        
        // Very long streaks
        $this->createStreak($advanced, 'daily_login', 45);
        $this->createStreak($advanced, 'task_completion', 30);
        $this->createStreak($advanced, 'content_creation', 15);
        
        // Multiple completed challenges
        $this->enrollInChallenge($advanced, 'Advanced Machine Learning', 100);
        $this->enrollInChallenge($advanced, 'Full Stack Development', 100);
        $this->enrollInChallenge($advanced, 'Mobile App Development', 100);
        
        // Create a frozen streak
        $this->createFrozenStreak($advanced, 'experience_points', 10, 3);

        // 4. IRREGULAR STUDENT - mixed progress, broken streaks, abandoned challenges
        $irregular = User::updateOrCreate(
            ['email' => 'irregular@example.com'],
            [
                'name' => 'Irregular Student',
                'password' => Hash::make('password'),
                'points' => 1200, // Direct points instead of using addPoints
            ]
        );
        $irregular->assignRole('student');
        
        // Some achievements with mixed progress
        $this->grantAchievement($irregular, 'Novice');
        $this->grantAchievement($irregular, 'Task Starter');
        $this->grantAchievement($irregular, 'Journeyman', 50);
        
        // Broken streaks (add to streak history)
        $this->createStreakHistory($irregular, 'daily_login', 5);
        $this->createStreakHistory($irregular, 'task_completion', 3);
        
        // Current low streaks
        $this->createStreak($irregular, 'daily_login', 1);
        
        // Abandoned and partial challenges
        $this->enrollInChallenge($irregular, 'Database Design', 45);
        $this->enrollInChallenge($irregular, 'Basic Algorithms', 60);

        // 5. COMPETITIVE STUDENT - focuses on challenges and achievements
        $competitive = User::updateOrCreate(
            ['email' => 'competitive@example.com'],
            [
                'name' => 'Competitive Student',
                'password' => Hash::make('password'),
                'points' => 4000, // Direct points instead of using addPoints
            ]
        );
        $competitive->assignRole('student');
        
        // Achievement focus
        $this->grantAchievement($competitive, 'Novice');
        $this->grantAchievement($competitive, 'Journeyman');
        $this->grantAchievement($competitive, 'Task Starter');
        $this->grantAchievement($competitive, 'Task Master');
        $this->grantAchievement($competitive, 'Consistent');
        
        // Moderate streaks
        $this->createStreak($competitive, 'daily_login', 12);
        $this->createStreak($competitive, 'task_completion', 12);
        
        // Many active challenges
        $this->enrollInChallenge($competitive, 'Competitive Programming', 90);
        $this->enrollInChallenge($competitive, 'Algorithm Mastery', 75);
        $this->enrollInChallenge($competitive, 'Data Structures Deep Dive', 80);
        $this->enrollInChallenge($competitive, 'Code Optimization', 65);

        // Create additional student users with random progression
        for ($i = 1; $i <= 20; $i++) {
            $points = rand(0, 2000);
            $user = User::updateOrCreate(
                ['email' => "student{$i}@example.com"],
                [
                    'name' => "Student {$i}",
                    'password' => Hash::make('password'),
                    'points' => $points,
                ]
            );
            $user->assignRole('student');
            
            // Random chance for achievements
            if (rand(0, 1)) {
                $this->grantAchievement($user, 'Novice');
            }
            
            if (rand(0, 2) == 2) {
                $this->grantAchievement($user, 'Journeyman');
            }
            
            if (rand(0, 3) == 3) {
                $this->grantAchievement($user, 'Task Starter');
            }
            
            // Random streaks between 0-10 days
            $streakDays = rand(0, 10);
            if ($streakDays > 0) {
                $this->createStreak($user, 'daily_login', $streakDays);
            }
            
            // Random chance to enroll in a challenge
            if (rand(0, 1)) {
                $challenges = ['Beginner Python', 'Web Development Basics', 'Database Design'];
                $challenge = $challenges[array_rand($challenges)];
                $progress = rand(10, 100);
                $this->enrollInChallenge($user, $challenge, $progress);
            }
        }
    }
    
    /**
     * Grant an achievement to a user with specified progress
     */
    private function grantAchievement(User $user, string $achievementName, int $progress = 100): void
    {
        $achievement = Achievement::where('name', $achievementName)->first();
        
        if ($achievement) {
            $user->grantAchievement($achievement, $progress);
        }
    }
    
    /**
     * Create a streak for a user
     */
    private function createStreak(User $user, string $activityName, int $count): void
    {
        $activity = DB::table('streak_activities')->where('name', $activityName)->first();
        
        if ($activity) {
            // Create the streak
            $streak = DB::table('streaks')->insertGetId([
                'user_id' => $user->id,
                'activity_id' => $activity->id,
                'count' => $count,
                'activity_at' => now()->subDays(1), // Yesterday to allow for streak continuation today
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Create a frozen streak for a user
     */
    private function createFrozenStreak(User $user, string $activityName, int $count, int $freezeDays): void
    {
        $activity = DB::table('streak_activities')->where('name', $activityName)->first();
        
        if ($activity) {
            // Create the streak with freeze
            $streak = DB::table('streaks')->insertGetId([
                'user_id' => $user->id,
                'activity_id' => $activity->id,
                'count' => $count,
                'activity_at' => now()->subDays(1),
                'frozen_until' => now()->addDays($freezeDays),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Create a streak history entry (for broken streaks)
     */
    private function createStreakHistory(User $user, string $activityName, int $count): void
    {
        $activity = DB::table('streak_activities')->where('name', $activityName)->first();
        
        if ($activity && DB::table('streak_histories')->exists()) {
            DB::table('streak_histories')->insert([
                'user_id' => $user->id,
                'activity_id' => $activity->id,
                'count' => $count,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
    
    /**
     * Enroll a user in a challenge with specified progress
     */
    private function enrollInChallenge(User $user, string $challengeName, int $progress): void
    {
        $challenge = Challenge::where('name', $challengeName)->first();
        
        if ($challenge) {
            try {
                // Enroll the user in the challenge
                $user->challenges()->attach($challenge->id, [
                    'status' => $progress >= 100 ? 'completed' : 'in_progress',
                    'progress' => $progress,
                    'completed_at' => $progress >= 100 ? now() : null,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
                
                // If challenge is completed, award any associated achievements
                if ($progress >= 100) {
                    foreach ($challenge->achievements as $achievement) {
                        $user->grantAchievement($achievement);
                    }
                }
            } catch (\Exception $e) {
                // Handle any exceptions (like level requirements not met)
            }
        }
    }
}
