<?php

namespace Database\Seeders;

use App\Models\ReferralProgram;
use Illuminate\Database\Seeder;

class ReferralProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Standard referral program
        ReferralProgram::create([
            'name' => 'Standard Referral',
            'description' => 'Standard referral program for new users',
            'referrer_points' => 50,
            'referee_points' => 25,
            'is_active' => true,
            'additional_rewards' => null,
        ]);

        // Premium referral program
        ReferralProgram::create([
            'name' => 'Premium Referral',
            'description' => 'Enhanced referral program with additional rewards',
            'referrer_points' => 100,
            'referee_points' => 50,
            'is_active' => true,
            'additional_rewards' => [
                'referrer' => ['badge_id' => 8], // Influencer badge for multiple referrals
                'referee' => ['feature' => 'premium_trial', 'days' => 3],
            ],
        ]);

        // Special event referral
        ReferralProgram::create([
            'name' => 'Special Event Referral',
            'description' => 'Limited-time referral program with increased rewards',
            'referrer_points' => 150,
            'referee_points' => 75,
            'is_active' => false, // Not currently active
            'additional_rewards' => [
                'referrer' => ['reward_id' => 3], // Large Point Bonus
                'referee' => ['reward_id' => 2], // Medium Point Bonus
            ],
        ]);
    }
}
