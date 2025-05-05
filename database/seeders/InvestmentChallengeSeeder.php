<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvestmentChallenge;

class InvestmentChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $challenges = [
            [
                'title' => 'Beginner Portfolio Builder',
                'description' => 'Create a diversified portfolio with at least 5 different stocks from various sectors.',
                'difficulty' => 'beginner',
                'duration_days' => 7,
                'points_reward' => 100,
                'is_active' => true,
                'starting_capital' => 100000.00,
                'target_return' => 5.00
            ],
            [
                'title' => 'Value Investing Challenge',
                'description' => 'Build a portfolio focusing on undervalued stocks with strong fundamentals and potential for growth.',
                'difficulty' => 'intermediate',
                'duration_days' => 14,
                'points_reward' => 200,
                'is_active' => true,
                'starting_capital' => 100000.00,
                'target_return' => 8.00
            ],
            [
                'title' => 'Dividend Income Strategy',
                'description' => 'Create a portfolio of dividend-paying stocks to maximize passive income while maintaining stability.',
                'difficulty' => 'advanced',
                'duration_days' => 21,
                'points_reward' => 300,
                'is_active' => true,
                'starting_capital' => 100000.00,
                'target_return' => 10.00
            ],
            [
                'title' => 'Market Volatility Navigator',
                'description' => 'Build a portfolio that can withstand market volatility while still generating positive returns.',
                'difficulty' => 'intermediate',
                'duration_days' => 10,
                'points_reward' => 150,
                'is_active' => true,
                'starting_capital' => 100000.00,
                'target_return' => 7.00
            ],
            [
                'title' => 'Sector Rotation Strategy',
                'description' => 'Implement a sector rotation strategy to capitalize on different phases of the economic cycle.',
                'difficulty' => 'advanced',
                'duration_days' => 30,
                'points_reward' => 350,
                'is_active' => true,
                'starting_capital' => 100000.00,
                'target_return' => 12.00
            ]
        ];

        foreach ($challenges as $challenge) {
            InvestmentChallenge::create($challenge);
        }
    }
}
