<?php

namespace Database\Seeders;

use App\Models\DailyRewardTier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDailyRewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get regular players (not admin or moderator)
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->get();

        // Get reward tiers
        $rewardTiers = DailyRewardTier::orderBy('day_number')->get();

        foreach ($users as $user) {
            // Determine a random streak length for each user (0-15 days)
            $streakLength = rand(0, 15);

            // No streak for some users
            if ($streakLength === 0) {
                continue;
            }

            // Create daily reward claims for the user's streak
            for ($day = 1; $day <= $streakLength; $day++) {
                // Find the appropriate reward tier
                $tier = $rewardTiers->where('day_number', $day)->first();

                // If no specific tier for this day, use day 1
                if (!$tier) {
                    $tier = $rewardTiers->where('day_number', 1)->first();
                }

                // Calculate the date (going backward from today)
                $claimDate = now()->subDays($streakLength - $day);

                DB::table('user_daily_rewards')->insert([
                    'user_id' => $user->id,
                    'daily_reward_tier_id' => $tier->id,
                    'claimed_at' => $claimDate,
                    'streak_date' => $claimDate->format('Y-m-d'),
                    'current_streak' => $day,
                    'created_at' => $claimDate,
                    'updated_at' => $claimDate,
                ]);
            }
        }
    }
}
