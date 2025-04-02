<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Challenge;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all challenges
        $challenges = Challenge::all();

        foreach ($challenges as $challenge) {
            // Calculate the total points from all tasks
            $totalPoints = DB::table('tasks')
                ->where('challenge_id', $challenge->id)
                ->sum('points_reward');

            // Update the challenge points_reward
            if ($totalPoints > 0) {
                $challenge->update([
                    'points_reward' => $totalPoints
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is updating data only, no schema changes to reverse
    }
};
