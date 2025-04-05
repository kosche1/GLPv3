<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class Level2BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Badge::create([
            'name' => 'Beginner',
            'description' => 'Reached level 2',
            'image' => 'badges/beginner.png',
            'trigger_type' => 'level',
            'trigger_conditions' => json_encode(['level' => 2]),
            'rarity_level' => 1,
            'is_hidden' => false,
        ]);
    }
}
