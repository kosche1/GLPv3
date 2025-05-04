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
                'duration' => 7,
                'points' => 100,
                'is_active' => true
            ],
            [
                'title' => 'Value Investing Challenge',
                'description' => 'Build a portfolio focusing on undervalued stocks with strong fundamentals and potential for growth.',
                'difficulty' => 'intermediate',
                'duration' => 14,
                'points' => 200,
                'is_active' => true
            ],
            [
                'title' => 'Dividend Income Strategy',
                'description' => 'Create a portfolio of dividend-paying stocks to maximize passive income while maintaining stability.',
                'difficulty' => 'advanced',
                'duration' => 21,
                'points' => 300,
                'is_active' => true
            ],
            [
                'title' => 'Market Volatility Navigator',
                'description' => 'Build a portfolio that can withstand market volatility while still generating positive returns.',
                'difficulty' => 'intermediate',
                'duration' => 10,
                'points' => 150,
                'is_active' => true
            ],
            [
                'title' => 'Sector Rotation Strategy',
                'description' => 'Implement a sector rotation strategy to capitalize on different phases of the economic cycle.',
                'difficulty' => 'advanced',
                'duration' => 30,
                'points' => 350,
                'is_active' => true
            ]
        ];

        foreach ($challenges as $challenge) {
            InvestmentChallenge::create($challenge);
        }
    }
}
