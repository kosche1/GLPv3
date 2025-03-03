<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daily tasks
        Task::create([
            'name' => 'Daily Check-in',
            'description' => 'Check in to the application once per day',
            'points_reward' => 10,
            'type' => 'daily',
            'is_active' => true,
            'completion_criteria' => ['action' => 'login', 'count' => 1],
            'additional_rewards' => null,
        ]);

        Task::create([
            'name' => 'Daily Activity',
            'description' => 'Perform at least 3 activities today',
            'points_reward' => 15,
            'type' => 'daily',
            'is_active' => true,
            'completion_criteria' => ['action' => 'activity', 'count' => 3],
            'additional_rewards' => null,
        ]);

        // Weekly tasks
        Task::create([
            'name' => 'Weekly Challenge',
            'description' => 'Complete a difficult weekly challenge',
            'points_reward' => 50,
            'type' => 'weekly',
            'is_active' => true,
            'completion_criteria' => ['action' => 'challenge', 'count' => 1],
            'additional_rewards' => ['badge_id' => 2],
        ]);

        Task::create([
            'name' => 'Weekly Social',
            'description' => 'Invite a friend to join this week',
            'points_reward' => 30,
            'type' => 'weekly',
            'is_active' => true,
            'completion_criteria' => ['action' => 'invite', 'count' => 1],
            'additional_rewards' => null,
        ]);

        // One-time tasks
        Task::create([
            'name' => 'Profile Setup',
            'description' => 'Complete your user profile',
            'points_reward' => 20,
            'type' => 'onetime',
            'is_active' => true,
            'completion_criteria' => ['action' => 'profile_complete', 'count' => 1],
            'additional_rewards' => null,
        ]);

        Task::create([
            'name' => 'Tutorial Completion',
            'description' => 'Complete the tutorial sequence',
            'points_reward' => 25,
            'type' => 'onetime',
            'is_active' => true,
            'completion_criteria' => ['action' => 'tutorial_complete', 'count' => 1],
            'additional_rewards' => null,
        ]);

        // Challenge tasks
        Task::create([
            'name' => 'Perfect Week',
            'description' => 'Complete all daily tasks for 7 consecutive days',
            'points_reward' => 100,
            'type' => 'challenge',
            'is_active' => true,
            'completion_criteria' => ['action' => 'daily_streak', 'count' => 7],
            'additional_rewards' => ['badge_id' => 6],
        ]);

        Task::create([
            'name' => 'Social Butterfly',
            'description' => 'Successfully refer 3 friends who join',
            'points_reward' => 150,
            'type' => 'challenge',
            'is_active' => true,
            'completion_criteria' => ['action' => 'successful_referrals', 'count' => 3],
            'additional_rewards' => ['badge_id' => 8],
        ]);
    }
}
