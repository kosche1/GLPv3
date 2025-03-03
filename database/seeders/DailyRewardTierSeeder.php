<?php

namespace Database\Seeders;

use App\Models\DailyRewardTier;
use Illuminate\Database\Seeder;

class DailyRewardTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Day 1-7 rewards (one week)
        DailyRewardTier::create([
            'name' => 'Day 1 Reward',
            'day_number' => 1,
            'points_reward' => 10,
            'reward_type' => 'points',
            'reward_data' => null,
        ]);

        DailyRewardTier::create([
            'name' => 'Day 2 Reward',
            'day_number' => 2,
            'points_reward' => 15,
            'reward_type' => 'points',
            'reward_data' => null,
        ]);

        DailyRewardTier::create([
            'name' => 'Day 3 Reward',
            'day_number' => 3,
            'points_reward' => 20,
            'reward_type' => 'points',
            'reward_data' => null,
        ]);

        DailyRewardTier::create([
            'name' => 'Day 4 Reward',
            'day_number' => 4,
            'points_reward' => 25,
            'reward_type' => 'points',
            'reward_data' => null,
        ]);

        DailyRewardTier::create([
            'name' => 'Day 5 Reward',
            'day_number' => 5,
            'points_reward' => 30,
            'reward_type' => 'points',
            'reward_data' => null,
        ]);

        DailyRewardTier::create([
            'name' => 'Day 6 Reward',
            'day_number' => 6,
            'points_reward' => 35,
            'reward_type' => 'points',
            'reward_data' => null,
        ]);

        DailyRewardTier::create([
            'name' => 'Day 7 Special Reward',
            'day_number' => 7,
            'points_reward' => 50,
            'reward_type' => 'badge',
            'reward_data' => ['badge_id' => 6], // Consistent badge
        ]);

        // Days 14, 21, 28 special rewards
        DailyRewardTier::create([
            'name' => 'Day 14 Special Reward',
            'day_number' => 14,
            'points_reward' => 75,
            'reward_type' => 'badge',
            'reward_data' => ['streak_freeze' => 1],
        ]);

        DailyRewardTier::create([
            'name' => 'Day 21 Special Reward',
            'day_number' => 21,
            'points_reward' => 100,
            'reward_type' => 'badge',
            'reward_data' => ['streak_freeze' => 2],
        ]);

        DailyRewardTier::create([
            'name' => 'Day 30 Super Reward',
            'day_number' => 30,
            'points_reward' => 200,
            'reward_type' => 'badge',
            'reward_data' => ['badge_id' => 7, 'streak_freeze' => 3], // Dedicated badge and streak freezes
        ]);
    }
}
