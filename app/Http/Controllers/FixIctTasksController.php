<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\Task;

class FixIctTasksController extends Controller
{
    public function fixTasks()
    {
        $results = [];

        // Find the Python Programming challenge
        $pythonChallenge = Challenge::where('name', 'Python Programming')
            ->where('tech_category', 'ict')
            ->first();

        if ($pythonChallenge) {
            // Update the challenge to be a debugging challenge
            $pythonChallenge->challenge_type = 'debugging';
            $pythonChallenge->challenge_content = [
                'scenario' => 'Debug these Python programs to fix the issues and make them work correctly.',
            ];
            $pythonChallenge->save();

            // Get the tasks for this challenge
            $tasks = Task::where('challenge_id', $pythonChallenge->id)->get();

            // Update the first task - Python List Operations
            $task1 = $tasks->where('name', 'Python List Operations')->first();
            if ($task1) {
                // Update the task with the exact instructions from the admin panel
                $task1->instructions = 'Write a Python program that creates a list of numbers from 1 to 10, then filters out all even numbers, and finally calculates the sum of the remaining odd numbers. Print the final sum.';

                $task1->challenge_content = [
                    'buggy_code' => "# Create a list of numbers from 1 to 10
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

# Filter out even numbers
odd_numbers = []
for num in numbers:
    if num / 2 == 0:  # Bug: This checks if num is divisible by 2 with no remainder
        odd_numbers.append(num)

# Calculate the sum
total = 0
for num in odd_numbers:
    total += num

print(f\"Sum of odd numbers: {total}\")",
                    'current_behavior' => 'The program is supposed to filter out even numbers and sum the odd ones, but it\'s not working correctly. The sum is always 0.',
                    'expected_behavior' => 'The program should correctly identify odd numbers (1, 3, 5, 7, 9) and calculate their sum (25).'
                ];
                $task1->save();
                $results[] = "Updated Python List Operations task with debugging content.";
            }

            // Update the second task - Python String Manipulation
            $task2 = $tasks->where('name', 'Python String Manipulation')->first();
            if ($task2) {
                $task2->challenge_content = [
                    'buggy_code' => "# Capitalize the first letter of each word
text = \"python is a powerful programming language\"

# Split the text into words
words = text.split()

# Capitalize each word
capitalized_words = []
for word in words:
    # Bug: This capitalizes the entire word instead of just the first letter
    capitalized_word = word.upper()
    capitalized_words.append(capitalized_word)

# Join the words back into a sentence
result = \" \".join(capitalized_words)

print(result)",
                    'current_behavior' => 'The program is capitalizing the entire word instead of just the first letter of each word.',
                    'expected_behavior' => 'The program should output "Python Is A Powerful Programming Language" with only the first letter of each word capitalized.'
                ];
                $task2->save();
                $results[] = "Updated Python String Manipulation task with debugging content.";
            }

            // Update the third task - Python Functions and Dictionaries
            $task3 = $tasks->where('name', 'Python Functions and Dictionaries')->first();
            if ($task3) {
                $task3->challenge_content = [
                    'buggy_code' => "# Function to calculate letter grades
def calculate_grades(scores):
    grades = {}
    for student, score in scores.items():
        # Bug: The grading scale is implemented incorrectly
        if score >= 90:
            grades[student] = 'A'
        if score >= 80:
            grades[student] = 'B'
        if score >= 70:
            grades[student] = 'C'
        if score >= 60:
            grades[student] = 'D'
        else:
            grades[student] = 'F'
    return grades

# Test the function
student_scores = {\"Alice\": 92, \"Bob\": 85, \"Charlie\": 70, \"David\": 60, \"Eve\": 55}
result = calculate_grades(student_scores)
print(result)",
                    'current_behavior' => 'The function is not assigning grades correctly. Everyone with a score of 60 or above is getting a "D" grade.',
                    'expected_behavior' => 'The function should correctly assign letter grades based on the grading scale: A (90-100), B (80-89), C (70-79), D (60-69), F (below 60).'
                ];
                $task3->save();
                $results[] = "Updated Python Functions and Dictionaries task with debugging content.";
            }

            $results[] = "Python Programming challenge updated to debugging challenge type.";
        } else {
            $results[] = "Python Programming challenge not found.";
        }

        // Find the JavaScript Programming challenge
        $jsChallenge = Challenge::where('name', 'JavaScript Programming')
            ->where('tech_category', 'ict')
            ->first();

        if ($jsChallenge) {
            // Update the challenge to be a debugging challenge
            $jsChallenge->challenge_type = 'debugging';
            $jsChallenge->challenge_content = [
                'scenario' => 'Debug these JavaScript programs to fix the issues and make them work correctly.',
            ];
            $jsChallenge->save();
            $results[] = "JavaScript Programming challenge updated to debugging challenge type.";
        } else {
            $results[] = "JavaScript Programming challenge not found.";
        }

        // Find the Java Programming challenge
        $javaChallenge = Challenge::where('name', 'Java Programming')
            ->where('tech_category', 'ict')
            ->first();

        if ($javaChallenge) {
            // Update the challenge to be a debugging challenge
            $javaChallenge->challenge_type = 'debugging';
            $javaChallenge->challenge_content = [
                'scenario' => 'Debug these Java programs to fix the issues and make them work correctly.',
            ];
            $javaChallenge->save();
            $results[] = "Java Programming challenge updated to debugging challenge type.";
        } else {
            $results[] = "Java Programming challenge not found.";
        }

        return response()->json([
            'results' => $results,
            'message' => 'ICT programming challenges have been updated with proper debugging tasks.'
        ]);
    }
}
