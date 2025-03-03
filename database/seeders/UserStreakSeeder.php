<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStreakSeeder extends Seeder
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

        // Get streak activities
        $activities = DB::table('streak_activities')->get();

        foreach ($users as $user) {
            // Each user has 1-3 streak activities
            $userActivities = $activities->random(rand(1, 3));

            foreach ($userActivities as $activity) {
                // Determine if user has an active streak (80% chance)
                $hasActiveStreak = rand(1, 10) <= 8;

                if ($hasActiveStreak) {
                    // Determine streak length (1-30 days)
                    $streakLength = rand(1, 30);

                    // Create active streak
                    DB::table('streaks')->insert([
                        'user_id' => $user->id,
                        'activity_id' => $activity->id,
                        'count' => $streakLength,
                        'activity_at' => now()->subDays(1), // Yesterday
                        'frozen_until' => rand(1, 10) === 1 ? now()->addDays(1) : null, // 10% chance of freeze
                        'created_at' => now()->subDays($streakLength),
                        'updated_at' => now(),
                    ]);
                }

                // Create streak history (past streaks that ended)
                $pastStreakCount = rand(0, 3);

                for ($i = 0; $i < $pastStreakCount; $i++) {
                    $pastStreakLength = rand(2, 15);
                    $endedDaysAgo = rand(5, 60);
                    $startedDaysAgo = $endedDaysAgo + $pastStreakLength;

                    DB::table('streak_histories')->insert([
                        'user_id' => $user->id,
                        'activity_id' => $activity->id,
                        'count' => $pastStreakLength,
                        'started_at' => now()->subDays($startedDaysAgo),
                        'ended_at' => now()->subDays($endedDaysAgo),
                        'created_at' => now()->subDays($startedDaysAgo),
                        'updated_at' => now()->subDays($endedDaysAgo),
                    ]);
                }
            }
        }
    }
}
