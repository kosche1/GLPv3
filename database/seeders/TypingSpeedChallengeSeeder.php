<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypingTestChallenge;

class TypingSpeedChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing challenges to prevent duplicates
        TypingTestChallenge::truncate();

        $challenges = [
            [
                'title' => 'Beginner Typing Challenge',
                'description' => 'Perfect for beginners to practice basic typing skills',
                'difficulty' => 'beginner',
                'test_mode' => 'words',
                'word_count' => 25,
                'time_limit' => 60,
                'target_wpm' => 20,
                'target_accuracy' => 80,
                'points_reward' => 50,
                'is_active' => true,
                'word_list' => null, // Will use default word bank
            ],
            [
                'title' => 'Intermediate Speed Test',
                'description' => 'Step up your typing speed with this intermediate challenge',
                'difficulty' => 'intermediate',
                'test_mode' => 'words',
                'word_count' => 50,
                'time_limit' => 90,
                'target_wpm' => 35,
                'target_accuracy' => 85,
                'points_reward' => 75,
                'is_active' => true,
                'word_list' => null,
            ],
            [
                'title' => 'Advanced Typing Marathon',
                'description' => 'Ultimate challenge for advanced typists',
                'difficulty' => 'advanced',
                'test_mode' => 'words',
                'word_count' => 100,
                'time_limit' => 120,
                'target_wpm' => 50,
                'target_accuracy' => 90,
                'points_reward' => 100,
                'is_active' => true,
                'word_list' => null,
            ],
            [
                'title' => '1-Minute Speed Challenge',
                'description' => 'Test your speed in just one minute',
                'difficulty' => 'intermediate',
                'test_mode' => 'time',
                'word_count' => 25,
                'time_limit' => 60,
                'target_wpm' => 40,
                'target_accuracy' => 85,
                'points_reward' => 60,
                'is_active' => true,
                'word_list' => null,
            ],
            [
                'title' => '2-Minute Endurance Test',
                'description' => 'Maintain your speed for two full minutes',
                'difficulty' => 'advanced',
                'test_mode' => 'time',
                'word_count' => 25,
                'time_limit' => 120,
                'target_wpm' => 45,
                'target_accuracy' => 88,
                'points_reward' => 90,
                'is_active' => true,
                'word_list' => null,
            ],
            [
                'title' => 'Programming Keywords Challenge',
                'description' => 'Practice typing programming-related terms',
                'difficulty' => 'intermediate',
                'test_mode' => 'words',
                'word_count' => 30,
                'time_limit' => 90,
                'target_wpm' => 30,
                'target_accuracy' => 85,
                'points_reward' => 80,
                'is_active' => true,
                'word_list' => null,
            ],
        ];

        foreach ($challenges as $challenge) {
            TypingTestChallenge::create($challenge);
        }

        $this->command->info('Typing Speed Challenges seeded successfully!');
    }
}
