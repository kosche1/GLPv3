<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;
use App\Models\Task;
use App\Models\Category;
use Carbon\Carbon;

class IctComputerProgrammingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the Computer Science category or create it
        $category = Category::firstOrCreate(
            ['slug' => 'computer-science'],
            [
                'name' => 'Computer Science',
                'description' => 'Computer Science and Programming related challenges'
            ]
        );

        // Create a challenge for Python programming
        $pythonChallenge = Challenge::create([
            'name' => 'Python Programming',
            'description' => 'Learn the basics of Python programming with simple exercises',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(),
            'points_reward' => 0, // Will be calculated from tasks
            'difficulty_level' => 'beginner',
            'is_active' => true,
            'required_level' => 1,
            'challenge_type' => 'coding_challenge',
            'programming_language' => 'python',
            'tech_category' => 'ict',
            'subject_type' => 'specialized',
            'category_id' => $category->id,
            'challenge_content' => [
                'scenario' => 'Practice Python programming with these beginner-friendly exercises',
                'buggy_code' => "# This code has a bug. Fix it to print 'Hello, World!'\nprint('Hello, World')",
                'current_behavior' => "The code prints 'Hello, World' without the exclamation mark",
                'expected_behavior' => "The code should print 'Hello, World!'"
            ]
        ]);

        // Create Python tasks
        $this->createPythonTasks($pythonChallenge);

        // Create a challenge for JavaScript programming
        $jsChallenge = Challenge::create([
            'name' => 'JavaScript Programming',
            'description' => 'Learn the fundamentals of JavaScript programming',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(),
            'points_reward' => 0, // Will be calculated from tasks
            'difficulty_level' => 'beginner',
            'is_active' => true,
            'required_level' => 1,
            'challenge_type' => 'coding_challenge',
            'programming_language' => 'javascript',
            'tech_category' => 'ict',
            'subject_type' => 'specialized',
            'category_id' => $category->id,
            'challenge_content' => [
                'scenario' => 'Practice JavaScript programming with these beginner-friendly exercises',
                'buggy_code' => "// This code has a bug. Fix it to print 'Hello, World!'\nconsole.log('Hello, World');",
                'current_behavior' => "The code prints 'Hello, World' without the exclamation mark",
                'expected_behavior' => "The code should print 'Hello, World!'"
            ]
        ]);

        // Create JavaScript tasks
        $this->createJavaScriptTasks($jsChallenge);

        // Create a challenge for Java programming
        $javaChallenge = Challenge::create([
            'name' => 'Java Programming',
            'description' => 'Learn the basics of Java programming with simple exercises',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(),
            'points_reward' => 0, // Will be calculated from tasks
            'difficulty_level' => 'beginner',
            'is_active' => true,
            'required_level' => 1,
            'challenge_type' => 'coding_challenge',
            'programming_language' => 'java',
            'tech_category' => 'ict',
            'subject_type' => 'specialized',
            'category_id' => $category->id,
            'challenge_content' => [
                'scenario' => 'Practice Java programming with these beginner-friendly exercises',
                'buggy_code' => "// This code has a bug. Fix it to print 'Hello, World!'\npublic class HelloWorld {\n    public static void main(String[] args) {\n        System.out.println(\"Hello, World\");\n    }\n}",
                'current_behavior' => "The code prints 'Hello, World' without the exclamation mark",
                'expected_behavior' => "The code should print 'Hello, World!'"
            ]
        ]);

        // Create Java tasks
        $this->createJavaTasks($javaChallenge);

        $this->command->info('ICT Computer Programming challenges seeded successfully!');
    }

    /**
     * Create Python programming tasks
     */
    private function createPythonTasks($challenge)
    {
        // Task 1: List Manipulation
        Task::create([
            'name' => 'Python List Operations',
            'title' => 'Working with Lists',
            'description' => 'Create and manipulate lists in Python to solve a practical problem.',
            'instructions' => 'Write a Python program that creates a list of numbers from 1 to 10, then filters out all even numbers, and finally calculates the sum of the remaining odd numbers. Print the final sum.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => '25'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 1
        ]);

        // Task 2: For Loop with String Manipulation
        Task::create([
            'name' => 'Python String Manipulation',
            'title' => 'String Processing with Loops',
            'description' => 'Use loops and string methods to process text data.',
            'instructions' => 'Write a program that takes the string "python is a powerful programming language" and capitalizes the first letter of each word. Print the resulting string.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => 'Python Is A Powerful Programming Language'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 2
        ]);

        // Task 3: Function Definition and Dictionary
        Task::create([
            'name' => 'Python Functions and Dictionaries',
            'title' => 'Creating Functions with Dictionaries',
            'description' => 'Define a function that works with dictionaries to solve a real-world problem.',
            'instructions' => 'Create a function called "calculate_grades" that takes a dictionary of student scores (where keys are student names and values are their scores) and returns a new dictionary with student names and their letter grades. Use the following grading scale: A (90-100), B (80-89), C (70-79), D (60-69), F (below 60). Test your function with this dictionary: {"Alice": 92, "Bob": 85, "Charlie": 70, "David": 60, "Eve": 55} and print the result.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => "{'Alice': 'A', 'Bob': 'B', 'Charlie': 'C', 'David': 'D', 'Eve': 'F'}"
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 3
        ]);

        // Update challenge points reward
        $challenge->updatePointsReward();
    }

    /**
     * Create JavaScript programming tasks
     */
    private function createJavaScriptTasks($challenge)
    {
        // Task 1: Array Methods
        Task::create([
            'name' => 'JavaScript Array Methods',
            'title' => 'Working with Array Methods',
            'description' => 'Use JavaScript array methods to transform and analyze data.',
            'instructions' => 'Write a JavaScript program that creates an array of numbers [12, 5, 8, 130, 44]. Use the filter method to create a new array with only numbers greater than 10, then use the map method to multiply each number by 2, and finally use the reduce method to calculate the sum of all numbers in the resulting array. Print the final sum.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => '372'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 1
        ]);

        // Task 2: DOM Manipulation
        Task::create([
            'name' => 'JavaScript DOM Manipulation',
            'title' => 'Creating and Modifying DOM Elements',
            'description' => 'Learn how to create and manipulate HTML elements using JavaScript.',
            'instructions' => 'Write JavaScript code that creates a new div element, sets its text content to "Hello, DOM!", adds a CSS class named "highlight" to it, and then appends it to the body element. Write the code as if it would be executed in a browser environment (you can use document.createElement, etc.).',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => 'Code should create a div with text "Hello, DOM!" and class "highlight", then append it to body'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 2
        ]);

        // Task 3: Asynchronous JavaScript
        Task::create([
            'name' => 'JavaScript Promises',
            'title' => 'Working with Promises',
            'description' => 'Learn how to use Promises for asynchronous operations in JavaScript.',
            'instructions' => 'Write a JavaScript function called "delayedGreeting" that takes a name as a parameter and returns a Promise. The Promise should resolve after a 2-second delay with the message "Hello, [name]!". Then, write code that calls this function with the name "JavaScript", and when the Promise resolves, prints the greeting message to the console.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => 'Hello, JavaScript!'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 3
        ]);

        // Update challenge points reward
        $challenge->updatePointsReward();
    }

    /**
     * Create Java programming tasks
     */
    private function createJavaTasks($challenge)
    {
        // Task 1: Object-Oriented Programming
        Task::create([
            'name' => 'Java Classes and Objects',
            'title' => 'Creating Classes and Objects',
            'description' => 'Learn how to define classes and create objects in Java.',
            'instructions' => 'Create a Java class called "Student" with private attributes for name (String), age (int), and grade (double). Include a constructor that initializes these attributes, getter and setter methods for each attribute, and a method called "isHonorRoll" that returns true if the grade is 3.5 or higher. Then, in the main method, create two Student objects with different values and print whether each student is on the honor roll.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => 'Code should define a Student class with appropriate attributes, methods, and demonstrate creating objects and calling the isHonorRoll method'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 1
        ]);

        // Task 2: Collections and Loops
        Task::create([
            'name' => 'Java Collections',
            'title' => 'Working with Collections',
            'description' => 'Learn how to use Java collections like ArrayList and HashMap.',
            'instructions' => 'Write a Java program that creates an ArrayList of integers containing the numbers 1 through 10. Use a for-each loop to iterate through the list and remove all even numbers. Then, create a HashMap that maps the remaining odd numbers to their squares (e.g., 1->1, 3->9, etc.). Finally, print all key-value pairs in the HashMap.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => 'Code should create an ArrayList, filter out even numbers, create a HashMap with odd numbers mapped to their squares, and print the key-value pairs'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 2
        ]);

        // Task 3: Exception Handling
        Task::create([
            'name' => 'Java Exception Handling',
            'title' => 'Working with Exceptions',
            'description' => 'Learn how to handle exceptions in Java.',
            'instructions' => 'Write a Java program that defines a method called "divideNumbers" which takes two integers as parameters and returns their division result as a double. The method should handle potential exceptions, such as division by zero, by throwing an appropriate exception with a meaningful message. In the main method, call this function with various inputs (including a division by zero scenario) and handle the exceptions appropriately by printing error messages.',
            'points_reward' => 100,
            'submission_type' => 'code',
            'evaluation_type' => 'manual',
            'evaluation_details' => [
                'expected_output' => 'Code should define a divideNumbers method that handles exceptions, and demonstrate calling it with various inputs including handling a division by zero exception'
            ],
            'is_active' => true,
            'challenge_id' => $challenge->id,
            'order' => 3
        ]);

        // Update challenge points reward
        $challenge->updatePointsReward();
    }
}
