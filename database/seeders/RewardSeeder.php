<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Point rewards
        Reward::create([
            'name' => 'Small Point Bonus',
            'description' => 'A small bonus of experience points',
            'type' => 'points',
            'reward_data' => ['points' => 25],
        ]);

        Reward::create([
            'name' => 'Medium Point Bonus',
            'description' => 'A medium bonus of experience points',
            'type' => 'points',
            'reward_data' => ['points' => 50],
        ]);

        Reward::create([
            'name' => 'Large Point Bonus',
            'description' => 'A large bonus of experience points',
            'type' => 'points',
            'reward_data' => ['points' => 100],
        ]);

        // Badge rewards
        Reward::create([
            'name' => 'Task Starter Badge',
            'description' => 'Unlock the Task Starter badge',
            'type' => 'badge',
            'reward_data' => ['badge_id' => 4], // Task Starter badge
        ]);

        Reward::create([
            'name' => 'Consistent Badge',
            'description' => 'Unlock the Consistent badge',
            'type' => 'badge',
            'reward_data' => ['badge_id' => 6], // Consistent badge
        ]);

        // Feature unlocks
        Reward::create([
            'name' => 'Streak Freeze',
            'description' => 'A freeze that prevents your streak from breaking for one day',
            'type' => 'feature',
            'reward_data' => ['feature' => 'streak_freeze', 'quantity' => 1],
        ]);

        Reward::create([
            'name' => 'Premium Content Access',
            'description' => 'Access to premium content for one week',
            'type' => 'feature',
            'reward_data' => ['feature' => 'premium_content', 'duration_days' => 7],
        ]);
    }
}
