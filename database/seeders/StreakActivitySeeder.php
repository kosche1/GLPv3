<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StreakActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('streak_activities')->insert([
            [
                'name' => 'daily_login',
                'description' => 'Logging into the application once per day',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'task_completion',
                'description' => 'Completing at least one task per day',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'experience_points',
                'description' => 'Earning any experience points during the day',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'content_creation',
                'description' => 'Creating or sharing content on the platform',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'social_engagement',
                'description' => 'Engaging with other users on the platform',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
