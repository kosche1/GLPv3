<?php

namespace Database\Seeders;

use App\Models\TypingTestChallenge;
use Illuminate\Database\Seeder;

class TypingTestChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $challenges = [
            [
                'title' => 'Beginner Typing Challenge',
                'description' => 'Perfect for students just starting their typing journey. Focus on accuracy over speed.',
                'difficulty' => 'beginner',
                'word_count' => 25,
                'time_limit' => 60,
                'test_mode' => 'words',
                'target_wpm' => 20,
                'target_accuracy' => 80,
                'points_reward' => 50,
                'is_active' => true,
                'word_list' => ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'had', 'her', 'was', 'one', 'our', 'out', 'day', 'get', 'has', 'him', 'his', 'how', 'man', 'new', 'now', 'old'],
            ],
            [
                'title' => 'Intermediate Speed Test',
                'description' => 'Build your typing speed while maintaining good accuracy. Ideal for developing typists.',
                'difficulty' => 'intermediate',
                'word_count' => 50,
                'time_limit' => 90,
                'test_mode' => 'words',
                'target_wpm' => 35,
                'target_accuracy' => 85,
                'points_reward' => 75,
                'is_active' => true,
                'word_list' => null, // Use default word bank
            ],
            [
                'title' => 'Advanced Typing Marathon',
                'description' => 'Challenge yourself with complex words and high-speed typing. For experienced typists only.',
                'difficulty' => 'advanced',
                'word_count' => 100,
                'time_limit' => 120,
                'test_mode' => 'words',
                'target_wpm' => 50,
                'target_accuracy' => 90,
                'points_reward' => 100,
                'is_active' => true,
                'word_list' => null, // Use default word bank
            ],
            [
                'title' => '1-Minute Speed Challenge',
                'description' => 'Type as many words as you can in exactly 60 seconds. Great for quick practice sessions.',
                'difficulty' => 'intermediate',
                'word_count' => 25,
                'time_limit' => 60,
                'test_mode' => 'time',
                'target_wpm' => 40,
                'target_accuracy' => 85,
                'points_reward' => 60,
                'is_active' => true,
                'word_list' => null, // Use default word bank
            ],
            [
                'title' => '2-Minute Endurance Test',
                'description' => 'Test your typing endurance and consistency over a longer period. Maintain your speed and accuracy.',
                'difficulty' => 'advanced',
                'word_count' => 25,
                'time_limit' => 120,
                'test_mode' => 'time',
                'target_wpm' => 45,
                'target_accuracy' => 88,
                'points_reward' => 90,
                'is_active' => true,
                'word_list' => null, // Use default word bank
            ],
            [
                'title' => 'Programming Keywords Challenge',
                'description' => 'Practice typing common programming terms and keywords. Perfect for ICT students.',
                'difficulty' => 'intermediate',
                'word_count' => 30,
                'time_limit' => 90,
                'test_mode' => 'words',
                'target_wpm' => 30,
                'target_accuracy' => 85,
                'points_reward' => 80,
                'is_active' => true,
                'word_list' => ['function', 'variable', 'array', 'object', 'class', 'method', 'string', 'integer', 'boolean', 'return', 'import', 'export', 'const', 'let', 'var', 'if', 'else', 'for', 'while', 'switch', 'case', 'break', 'continue', 'try', 'catch', 'throw', 'async', 'await', 'promise', 'callback'],
            ],
        ];

        foreach ($challenges as $challengeData) {
            // Set created_by to null for seeded data
            $challengeData['created_by'] = null;
            TypingTestChallenge::create($challengeData);
        }

        $this->command->info('Typing Test Challenges seeded successfully!');
    }
}
