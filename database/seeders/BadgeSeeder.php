<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Level-based badges
        Badge::create([
            'name' => 'Novice',
            'description' => 'Reached level 5',
            'image' => 'badges/novice.png',
            'trigger_type' => 'level',
            'trigger_conditions' => ['level' => 5],
            'rarity_level' => 1,
            'is_hidden' => false,
        ]);

        Badge::create([
            'name' => 'Journeyman',
            'description' => 'Reached level 10',
            'image' => 'badges/journeyman.png',
            'trigger_type' => 'level',
            'trigger_conditions' => ['level' => 10],
            'rarity_level' => 2,
            'is_hidden' => false,
        ]);

        Badge::create([
            'name' => 'Master',
            'description' => 'Reached level 25',
            'image' => 'badges/master.png',
            'trigger_type' => 'level',
            'trigger_conditions' => ['level' => 25],
            'rarity_level' => 4,
            'is_hidden' => false,
        ]);

        // Task-based badges
        Badge::create([
            'name' => 'Task Starter',
            'description' => 'Completed your first task',
            'image' => 'badges/task_starter.png',
            'trigger_type' => 'task',
            'trigger_conditions' => ['tasks_completed' => 1],
            'rarity_level' => 1,
            'is_hidden' => false,
        ]);

        Badge::create([
            'name' => 'Task Master',
            'description' => 'Completed 50 tasks',
            'image' => 'badges/task_master.png',
            'trigger_type' => 'task',
            'trigger_conditions' => ['tasks_completed' => 50],
            'rarity_level' => 3,
            'is_hidden' => false,
        ]);

        // Streak badges
        Badge::create([
            'name' => 'Consistent',
            'description' => 'Maintained a 7-day streak',
            'image' => 'badges/consistent.png',
            'trigger_type' => 'streak',
            'trigger_conditions' => ['streak_days' => 7],
            'rarity_level' => 2,
            'is_hidden' => false,
        ]);

        Badge::create([
            'name' => 'Dedicated',
            'description' => 'Maintained a 30-day streak',
            'image' => 'badges/dedicated.png',
            'trigger_type' => 'streak',
            'trigger_conditions' => ['streak_days' => 30],
            'rarity_level' => 4,
            'is_hidden' => false,
        ]);

        // Referral badges
        Badge::create([
            'name' => 'Influencer',
            'description' => 'Referred 5 new users',
            'image' => 'badges/influencer.png',
            'trigger_type' => 'referral',
            'trigger_conditions' => ['referrals' => 5],
            'rarity_level' => 3,
            'is_hidden' => false,
        ]);

        // Hidden achievement badge
        Badge::create([
            'name' => 'Mystery Solver',
            'description' => 'Discovered a hidden feature',
            'image' => 'badges/mystery.png',
            'trigger_type' => 'achievement',
            'trigger_conditions' => ['hidden_feature' => true],
            'rarity_level' => 5,
            'is_hidden' => true,
        ]);
    }
}
