<?php

namespace Database\Seeders;

use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChallengeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Standard Challenge
        Challenge::create([
            "name" => "Complete 5 Activities Challenge",
            "description" =>
                "Complete 5 different learning activities to earn points and badges.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 100,
            "difficulty_level" => "easy",
            "is_active" => true,
            "max_participants" => 100,
            "required_level" => 1,
            "challenge_type" => "standard",
            "completion_criteria" => [
                "activity_count" => 5,
                "min_score" => 70,
            ],
        ]);

        // 2. Flashcard Challenge
        Challenge::create([
            "name" => "Programming Concepts Flashcards",
            "description" =>
                "Master programming concepts by completing this flashcard challenge.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(7),
            "points_reward" => 150,
            "difficulty_level" => "medium",
            "is_active" => true,
            "max_participants" => 50,
            "required_level" => 2,
            "challenge_type" => "flashcard",
            "time_limit" => 30, // 30 minutes
            "challenge_content" => [
                [
                    "question" => "What is a variable?",
                    "answer" =>
                        "A named storage location in memory that can hold a value",
                ],
                [
                    "question" => "What is a function?",
                    "answer" =>
                        "A reusable block of code designed to perform a specific task",
                ],
                [
                    "question" => "What is inheritance in OOP?",
                    "answer" =>
                        "A mechanism where a class can inherit properties and methods from another class",
                ],
                [
                    "question" =>
                        "What is the difference between == and === in JavaScript?",
                    "answer" =>
                        "== compares values, while === compares both values and types",
                ],
                [
                    "question" => "What is an algorithm?",
                    "answer" =>
                        "A step-by-step procedure for solving a problem or accomplishing a task",
                ],
            ],
        ]);

        // 3. Crossword Puzzle Challenge
        Challenge::create([
            "name" => "Web Development Terminology Crossword",
            "description" =>
                "Test your knowledge of web development terms in this fun crossword puzzle.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(10),
            "points_reward" => 200,
            "difficulty_level" => "medium",
            "is_active" => true,
            "max_participants" => 75,
            "required_level" => 3,
            "challenge_type" => "crossword",
            "time_limit" => 45, // 45 minutes
            "challenge_content" => [
                [
                    "key" => "Language used to structure web content",
                    "value" => "HTML",
                ],
                [
                    "key" => "Styling language for web pages",
                    "value" => "CSS",
                ],
                [
                    "key" => "Client-side scripting language",
                    "value" => "JAVASCRIPT",
                ],
                [
                    "key" =>
                        "Server-side scripting language created by Rasmus Lerdorf",
                    "value" => "PHP",
                ],
                [
                    "key" => "A framework for building user interfaces",
                    "value" => "REACT",
                ],
                [
                    "key" => "Data interchange format commonly used with APIs",
                    "value" => "JSON",
                ],
                [
                    "key" => "Method to request data from a server",
                    "value" => "GET",
                ],
                [
                    "key" => "Method to send data to a server",
                    "value" => "POST",
                ],
            ],
        ]);

        // 4. Word Search Challenge
        Challenge::create([
            "name" => "Data Science Terms Word Search",
            "description" =>
                "Find all the data science terms hidden in this word search puzzle.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(5),
            "points_reward" => 120,
            "difficulty_level" => "easy",
            "is_active" => true,
            "max_participants" => 100,
            "required_level" => 1,
            "challenge_type" => "word_search",
            "time_limit" => 20, // 20 minutes
            "challenge_content" => [
                "grid_size" => 15,
                "words" => [
                    "PYTHON",
                    "ALGORITHM",
                    "DATABASE",
                    "ANALYTICS",
                    "STATISTICS",
                    "REGRESSION",
                    "CLUSTERING",
                    "MACHINE",
                    "LEARNING",
                    "NEURAL",
                    "NETWORK",
                    "VISUALIZATION",
                    "PANDAS",
                    "TENSORFLOW",
                ],
            ],
        ]);

        // 5. Quiz Challenge
        Challenge::create([
            "name" => "Cloud Computing Mastery Quiz",
            "description" =>
                "Test your knowledge about cloud computing concepts and services.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(7),
            "points_reward" => 180,
            "difficulty_level" => "hard",
            "is_active" => true,
            "max_participants" => 50,
            "required_level" => 4,
            "challenge_type" => "quiz",
            "time_limit" => 25, // 25 minutes
            "challenge_content" => [
                [
                    "question" =>
                        "What is the main advantage of cloud computing?",
                    "options" => [
                        "Lower cost",
                        "Scalability",
                        "Better security",
                        "Faster performance",
                    ],
                    "correct_answer" => 1, // Scalability (index 1)
                ],
                [
                    "question" =>
                        "Which of these is NOT a major cloud service model?",
                    "options" => [
                        "Infrastructure as a Service (IaaS)",
                        "Platform as a Service (PaaS)",
                        "Software as a Service (SaaS)",
                        "Hardware as a Service (HaaS)",
                    ],
                    "correct_answer" => 3, // HaaS (index 3)
                ],
                [
                    "question" =>
                        "Which company offers the AWS cloud platform?",
                    "options" => ["Microsoft", "Google", "Amazon", "IBM"],
                    "correct_answer" => 2, // Amazon (index 2)
                ],
                [
                    "question" =>
                        "What is a cloud deployment model where services are shared by multiple organizations?",
                    "options" => [
                        "Public cloud",
                        "Private cloud",
                        "Community cloud",
                        "Hybrid cloud",
                    ],
                    "correct_answer" => 2, // Community cloud (index 2)
                ],
                [
                    "question" =>
                        "Which of these is a characteristic of cloud computing?",
                    "options" => [
                        "Limited resource pooling",
                        "On-demand self-service",
                        "Fixed bandwidth",
                        "Single-tenant architecture",
                    ],
                    "correct_answer" => 1, // On-demand self-service (index 1)
                ],
            ],
        ]);

        // 6. Coding Challenge
        Challenge::create([
            "name" => "Algorithmic Problem Solving",
            "description" =>
                "Solve coding problems to improve your algorithmic thinking and programming skills.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 300,
            "difficulty_level" => "expert",
            "is_active" => true,
            "max_participants" => 30,
            "required_level" => 5,
            "challenge_type" => "coding",
            "time_limit" => 120, // 2 hours
            "challenge_content" => [
                [
                    "title" => "Reverse a String",
                    "description" =>
                        "Write a function that reverses a string without using built-in reverse functions.",
                    "example_input" => "hello",
                    "example_output" => "olleh",
                    "test_cases" => [
                        ["input" => "hello", "output" => "olleh"],
                        ["input" => "world", "output" => "dlrow"],
                        ["input" => "12345", "output" => "54321"],
                    ],
                ],
                [
                    "title" => "Find the Missing Number",
                    "description" =>
                        "Given an array containing n distinct numbers taken from 0 to n, find the missing number.",
                    "example_input" => "[3,0,1]",
                    "example_output" => "2",
                    "test_cases" => [
                        ["input" => "[3,0,1]", "output" => "2"],
                        ["input" => "[9,6,4,2,3,5,7,0,1]", "output" => "8"],
                        ["input" => "[0]", "output" => "1"],
                    ],
                ],
            ],
        ]);
    }
}
