<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RunSpecializedTrackSeeders extends Seeder
{
    /**
     * Run the specialized track seeders.
     */
    public function run(): void
    {
        $this->call([
            StemSubjectsSeeder::class,
            AbmSubjectsSeeder::class,
            HumssSubjectsSeeder::class,
            HeSubjectsSeeder::class,
            IctSubjectsSeeder::class,
        ]);
    }
}
