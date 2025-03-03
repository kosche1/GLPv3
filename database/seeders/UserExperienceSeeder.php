<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users except admin
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->get();

        // Get all levels
        $levels = DB::table('levels')->get();

        foreach ($users as $user) {
            // Randomly select a level for the user (between 1 and 20)
            $randomLevel = rand(1, 20);
            $level = $levels->where('level', $randomLevel)->first();

            // Calculate experience points within the level range
            $minExp = $levels->where('level', $randomLevel - 1)->first()->next_level_experience ?? 0;
            $maxExp = $level->next_level_experience ?? ($minExp + 1000);
            $expPoints = rand($minExp, $maxExp);

            // Create experience record for user
            Experience::create([
                'user_id' => $user->id,
                'level_id' => $level->id,
                'experience_points' => $expPoints,
            ]);

            // Create some experience audit records
            $auditTypes = ['add', 'add', 'add', 'remove', 'level_up'];
            $auditReasons = [
                'Daily login', 'Task completion', 'Streak bonus',
                'Penalty for inactivity', 'Level up reward'
            ];

            // Random number of audit records (2-5)
            $numAudits = rand(2, 5);

            for ($i = 0; $i < $numAudits; $i++) {
                $typeIndex = array_rand($auditTypes);
                $reasonIndex = array_rand($auditReasons);

                DB::table('experience_audits')->insert([
                    'user_id' => $user->id,
                    'points' => $auditTypes[$typeIndex] === 'remove' ? -rand(5, 20) : rand(10, 50),
                    'levelled_up' => $auditTypes[$typeIndex] === 'level_up',
                    'level_to' => $auditTypes[$typeIndex] === 'level_up' ? $randomLevel : null,
                    'type' => $auditTypes[$typeIndex],
                    'reason' => $auditReasons[$reasonIndex],
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
