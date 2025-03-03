<?php

namespace Database\Seeders;

use App\Models\LeaderboardCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaderboardEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = LeaderboardCategory::where('is_active', true)->get();

        // Get users
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->get();

        foreach ($categories as $category) {
            // Set time periods based on category timeframe
            switch ($category->timeframe) {
                case 'daily':
                    $periodStart = now()->startOfDay();
                    $periodEnd = now()->endOfDay();
                    break;

                case 'weekly':
                    $periodStart = now()->startOfWeek();
                    $periodEnd = now()->endOfWeek();
                    break;

                case 'monthly':
                    $periodStart = now()->startOfMonth();
                    $periodEnd = now()->endOfMonth();
                    break;

                case 'alltime':
                default:
                    $periodStart = null;
                    $periodEnd = null;
                    break;
            }

            // Create leaderboard entries for this category
            $position = 1;

            // Shuffle users to randomize leaderboard
            $shuffledUsers = $users->shuffle();

            foreach ($shuffledUsers as $user) {
                // Generate a score based on the category metric
                $score = $this->generateScore($category->metric, $position);

                DB::table('leaderboard_entries')->insert([
                    'leaderboard_category_id' => $category->id,
                    'user_id' => $user->id,
                    'score' => $score,
                    'rank' => $position,
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $position++;
            }
        }
    }

    /**
     * Generate an appropriate score for the given metric and position.
     *
     * @param string $metric
     * @param int $position
     * @return int
     */
    private function generateScore(string $metric, int $position): int
    {
        // Base score is inversely proportional to position
        $baseScore = max(1000 - ($position * 20), 100);

        // Add some randomness
        $randomFactor = rand(80, 120) / 100;
        $score = round($baseScore * $randomFactor);

        // Adjust based on metric
        switch ($metric) {
            case 'points':
                return $score;

            case 'tasks':
                return max(round($score / 100), 1); // 1-20 tasks approximately

            case 'streaks':
                return max(round($score / 200), 1); // 1-10 day streaks approximately

            case 'referrals':
                return max(round($score / 500), 0); // 0-5 referrals approximately

            default:
                return $score;
        }
    }
}
