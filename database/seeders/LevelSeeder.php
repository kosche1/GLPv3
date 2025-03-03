<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [];

        // Level 1 (starting level) to Level 50
        for ($i = 1; $i <= 50; $i++) {
            $levels[] = [
                'level' => $i,
                'next_level_experience' => $i === 50 ? null : (100 * $i * ($i + 1)) / 2, // Formula creates increasing difficulty
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('levels')->insert($levels);
    }
}
