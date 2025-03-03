<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBadgeSeeder extends Seeder
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

        // Get all badges
        $badges = Badge::all();

        foreach ($users as $user) {
            // Each user gets 1-3 badges randomly
            $numBadges = rand(1, 3);
            $userBadges = $badges->random($numBadges);

            foreach ($userBadges as $badge) {
                // Only add non-hidden badges for seeding, except for rarely
                if (!$badge->is_hidden || rand(1, 10) === 1) {
                    DB::table('user_badges')->insert([
                        'user_id' => $user->id,
                        'badge_id' => $badge->id,
                        'earned_at' => now()->subDays(rand(1, 30)),
                        'is_pinned' => rand(0, 1) === 1,
                        'is_showcased' => rand(0, 5) === 1, // Rarely showcased
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
