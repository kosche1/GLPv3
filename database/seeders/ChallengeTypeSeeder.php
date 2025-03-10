<?php

namespace Database\Seeders;

use App\Models\Challenge;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChallengeTypeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Coding Challenge - Python Basics
        Challenge::create([
            "name" => "Python Fundamentals Challenge",
            "description" => "Test your knowledge of Python basics including variables, data types, loops, and functions.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(7),
            "points_reward" => 150,
            "difficulty_level" => "beginner",
            "is_active" => true,
            "max_participants" => 100,
            "required_level" => 1,
            "challenge_type" => "quiz",
            "time_limit" => 30, // 30 minutes
            "programming_language" => "python",
            "tech_category" => "general",
            "challenge_content" => [
                "questions" => [
                    [
                        "question" => "Which of the following is NOT a valid Python data type?",
                        "options" => [
                            ["text" => "int", "is_correct" => false],
                            ["text" => "float", "is_correct" => false],
                            ["text" => "char", "is_correct" => true],
                            ["text" => "bool", "is_correct" => false],
                        ],
                        "points" => 1
                    ],
                    [
                        "question" => "What will be the output of the following code?\n\nx = 5\nif x > 3:\n    print('Greater')\nelse:\n    print('Lesser')",
                        "options" => [
                            ["text" => "Greater", "is_correct" => true],
                            ["text" => "Lesser", "is_correct" => false],
                            ["text" => "Error", "is_correct" => false],
                            ["text" => "No output", "is_correct" => false],
                        ],
                        "points" => 1
                    ],
                    [
                        "question" => "How do you create a list in Python?",
                        "options" => [
                            ["text" => "list = (1, 2, 3)", "is_correct" => false],
                            ["text" => "list = [1, 2, 3]", "is_correct" => true],
                            ["text" => "list = {1, 2, 3}", "is_correct" => false],
                            ["text" => "list = '1, 2, 3'", "is_correct" => false],
                        ],
                        "points" => 1
                    ],
                    [
                        "question" => "Which method is used to add an element to the end of a list?",
                        "options" => [
                            ["text" => "append()", "is_correct" => true],
                            ["text" => "add()", "is_correct" => false],
                            ["text" => "insert()", "is_correct" => false],
                            ["text" => "extend()", "is_correct" => false],
                        ],
                        "points" => 1
                    ],
                    [
                        "question" => "What is the correct way to define a function in Python?",
                        "options" => [
                            ["text" => "function my_func():", "is_correct" => false],
                            ["text" => "def my_func():", "is_correct" => true],
                            ["text" => "create my_func():", "is_correct" => false],
                            ["text" => "func my_func():", "is_correct" => false],
                        ],
                        "points" => 1
                    ],
                ]
            ],
        ]);

        // 2. JavaScript Debugging Challenge
        Challenge::create([
            "name" => "JavaScript Debugging Challenge",
            "description" => "Find and fix the bugs in the JavaScript code snippets.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(10),
            "points_reward" => 200,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 50,
            "required_level" => 3,
            "challenge_type" => "debugging",
            "time_limit" => 45, // 45 minutes
            "programming_language" => "javascript",
            "tech_category" => "web_dev",
            "challenge_content" => [
                "scenario" => "You're working on a web application and need to fix several JavaScript bugs that are causing the application to malfunction.",
                "buggy_code" => "// Bug 1: Event listener not working\ndocument.getElementByID('submit-button').addEventListener('click', submitForm);\n\n// Bug 2: Incorrect array manipulation\nfunction processArray(arr) {\n  for(let i = 0; i <= arr.length; i++) {\n    console.log(arr[i].name);\n  }\n}\n\n// Bug 3: Async function issue\nasync function fetchData() {\n  const response = await fetch('https://api.example.com/data');\n  return response;\n}\n\n// Bug 4: Closure problem\nfunction createCounter() {\n  var count = 0;\n  return {\n    increment: function() { count++; },\n    getCount: function() { return count; }\n  }\n}\nconst counter1 = createCounter();\nconst counter2 = createCounter();\ncounter1.increment();\nconsole.log(counter2.getCount());",
                "expected_behavior" => "1. The submit button should trigger the submitForm function when clicked.\n2. The processArray function should correctly iterate through the array and log each item's name.\n3. The fetchData function should return the parsed JSON data.\n4. The counter should maintain its own state.",
                "current_behavior" => "1. The event listener is not attaching to the button.\n2. The loop is causing an undefined error at the end of the array.\n3. The fetchData function returns a Response object instead of the data.\n4. Counter2 is showing the count from counter1.",
                "hints" => [
                    ["hint" => "Check the DOM selector method spelling"],
                    ["hint" => "Array indices start at 0 and end at length-1"],
                    ["hint" => "Remember to parse the response to JSON"],
                    ["hint" => "Each counter should maintain its own independent state"]
                ]
            ],
        ]);

        // 3. Database Design Challenge
        Challenge::create([
            "name" => "SQL Database Challenge",
            "description" => "Design and query a database for an e-commerce platform.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 250,
            "difficulty_level" => "advanced",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 5,
            "challenge_type" => "database",
            "time_limit" => 60, // 60 minutes
            "programming_language" => "sql",
            "tech_category" => "databases",
            "challenge_content" => [
                "scenario" => "You are tasked with designing a database for an e-commerce platform that needs to track products, customers, orders, and reviews.",
                "schema" => "-- Existing tables:\n\nCREATE TABLE customers (\n  customer_id INT PRIMARY KEY,\n  name VARCHAR(100),\n  email VARCHAR(100),\n  registration_date DATE\n);\n\nCREATE TABLE products (\n  product_id INT PRIMARY KEY,\n  name VARCHAR(100),\n  description TEXT,\n  price DECIMAL(10,2),\n  stock_quantity INT\n);\n\nCREATE TABLE orders (\n  order_id INT PRIMARY KEY,\n  customer_id INT,\n  order_date DATE,\n  total_amount DECIMAL(10,2),\n  status VARCHAR(20),\n  FOREIGN KEY (customer_id) REFERENCES customers(customer_id)\n);\n\nCREATE TABLE order_items (\n  order_id INT,\n  product_id INT,\n  quantity INT,\n  price_per_unit DECIMAL(10,2),\n  PRIMARY KEY (order_id, product_id),\n  FOREIGN KEY (order_id) REFERENCES orders(order_id),\n  FOREIGN KEY (product_id) REFERENCES products(product_id)\n);",
                "tasks" => "1. Create a new table for product reviews with appropriate foreign keys.\n2. Write a query to find the top 5 customers who have spent the most money.\n3. Write a query to find products that have never been ordered.\n4. Create a view that shows each product along with its average review rating.\n5. Write a stored procedure that updates product stock quantities when a new order is placed.",
                "sample_data" => "-- Sample data available in the database\n\n-- Customers\nINSERT INTO customers VALUES (1, 'John Smith', 'john@example.com', '2022-01-15');\nINSERT INTO customers VALUES (2, 'Jane Doe', 'jane@example.com', '2022-02-20');\nINSERT INTO customers VALUES (3, 'Bob Johnson', 'bob@example.com', '2022-03-10');\n\n-- Products\nINSERT INTO products VALUES (101, 'Laptop', 'High-performance laptop', 1200.00, 15);\nINSERT INTO products VALUES (102, 'Smartphone', 'Latest model smartphone', 800.00, 25);\nINSERT INTO products VALUES (103, 'Headphones', 'Noise-cancelling headphones', 150.00, 40);\nINSERT INTO products VALUES (104, 'Tablet', '10-inch tablet', 300.00, 20);\nINSERT INTO products VALUES (105, 'Smartwatch', 'Fitness tracking watch', 250.00, 30);\n\n-- Orders\nINSERT INTO orders VALUES (1001, 1, '2023-01-05', 1350.00, 'Delivered');\nINSERT INTO orders VALUES (1002, 2, '2023-01-10', 800.00, 'Delivered');\nINSERT INTO orders VALUES (1003, 3, '2023-01-15', 450.00, 'Processing');\nINSERT INTO orders VALUES (1004, 1, '2023-02-01', 250.00, 'Delivered');\n\n-- Order Items\nINSERT INTO order_items VALUES (1001, 101, 1, 1200.00);\nINSERT INTO order_items VALUES (1001, 103, 1, 150.00);\nINSERT INTO order_items VALUES (1002, 102, 1, 800.00);\nINSERT INTO order_items VALUES (1003, 103, 3, 150.00);\nINSERT INTO order_items VALUES (1004, 105, 1, 250.00);"
            ],
        ]);

        // Continue with more IT-focused challenges...
    }
}