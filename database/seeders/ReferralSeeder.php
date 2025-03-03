<?php

namespace Database\Seeders;

use App\Models\ReferralProgram;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferralSeeder extends Seeder
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

        // Get referral programs
        $programs = ReferralProgram::where('is_active', true)->get();
        $defaultProgram = $programs->first();

        // Generate some referrals between users
        $referrerCount = $users->count() / 3; // About a third of users are referrers
        $referrers = $users->random($referrerCount);
        $potentialReferees = $users->diff($referrers);

        foreach ($referrers as $referrer) {
            // Each referrer refers 1-3 people
            $refereeCount = rand(1, 3);
            $actualReferees = $potentialReferees->random(min($refereeCount, $potentialReferees->count()));

            foreach ($actualReferees as $referee) {
                // Select a random program for this referral
                $program = $programs->random();

                // Generate a unique referral code
                $referralCode = strtoupper(Str::random(8));

                // Determine status randomly (mostly completed)
                $statusOptions = ['pending', 'completed', 'rewarded'];
                $statusWeights = [1, 3, 6]; // Weighted towards rewarded
                $status = $this->weightedRandom($statusOptions, $statusWeights);

                // Set dates and reward flags based on status
                $completedAt = $status !== 'pending' ? now()->subDays(rand(1, 30)) : null;
                $referrerRewarded = $status === 'rewarded';
                $refereeRewarded = $status === 'rewarded';

                DB::table('referrals')->insert([
                    'referrer_id' => $referrer->id,
                    'referee_id' => $referee->id,
                    'referral_program_id' => $program->id,
                    'referral_code' => $referralCode,
                    'status' => $status,
                    'completed_at' => $completedAt,
                    'referrer_rewarded' => $referrerRewarded,
                    'referee_rewarded' => $refereeRewarded,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => $completedAt ?? now()->subDays(rand(1, 60)),
                ]);

                // Remove this referee from potential referees for next iteration
                $potentialReferees = $potentialReferees->filter(function ($user) use ($referee) {
                    return $user->id !== $referee->id;
                });
            }
        }
    }

    /**
     * Get a random element with weighted probability.
     *
     * @param array $options
     * @param array $weights
     * @return mixed
     */
    private function weightedRandom(array $options, array $weights)
    {
        $totalWeight = array_sum($weights);
        $rand = rand(1, $totalWeight);

        $currentWeight = 0;
        foreach ($options as $index => $option) {
            $currentWeight += $weights[$index];
            if ($rand <= $currentWeight) {
                return $option;
            }
        }

        return $options[0]; // Fallback
    }
}
