<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\Category;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChallengeTypeSeeder extends Seeder
{
    public function run(): void
    {
        // First ensure we have categories for different subject areas
        $this->createCategoriesIfNeeded();

        // Get category IDs
        $categories = Category::pluck("id", "slug")->toArray();

        // ======= IT/COMPUTER SCIENCE CHALLENGES =======

        // 1. Debugging Challenge - Security Vulnerability Assessment
        $securityChallenge = Challenge::create([
            "name" => "Web Security Vulnerability Assessment",
            "description" =>
                "Identify and fix common security vulnerabilities in a web application including XSS, CSRF, and SQL injection vulnerabilities.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(10),
            "points_reward" => 0,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 50,
            "required_level" => 4,
            "challenge_type" => "debugging",
            "time_limit" => 120,
            "programming_language" => "php",
            "tech_category" => "security",
            "category_id" => $categories["computer-science"] ?? null,
            "challenge_content" => [
                "scenario" =>
                    "You're a security consultant hired to assess a client's e-commerce application for vulnerabilities before its launch. You've been provided with code snippets that need to be reviewed and fixed.",
                "buggy_code" =>
                    "<?php\n// User search function with SQL injection vulnerability\nfunction searchUsers(\$query) {\n    global \$db;\n    \$sql = \"SELECT * FROM users WHERE username LIKE '%\" . \$query . \"%'\";\n    return \$db->query(\$sql);\n}\n\n// Login form with CSRF vulnerability\nfunction renderLoginForm() {\n    echo '<form method=\"POST\" action=\"/login.php\">';\n    echo '<input type=\"text\" name=\"username\" placeholder=\"Username\">';\n    echo '<input type=\"password\" name=\"password\" placeholder=\"Password\">';\n    echo '<button type=\"submit\">Login</button>';\n    echo '</form>';\n}\n\n// Output user data with XSS vulnerability\nfunction displayUserProfile(\$userData) {\n    echo '<h2>Welcome back, ' . \$userData['name'] . '</h2>';\n    echo '<div>Bio: ' . \$userData['bio'] . '</div>';\n    echo '<div>Website: ' . \$userData['website'] . '</div>';\n}\n\n// Password reset with insecure practices\nfunction resetPassword(\$email) {\n    global \$db;\n    \$newPassword = 'reset' . rand(1000, 9999);\n    \$query = \"UPDATE users SET password = '\" . \$newPassword . \"' WHERE email = '\" . \$email . \"'\";\n    \$db->query(\$query);\n    mail(\$email, 'Password Reset', \"Your new password is: \" . \$newPassword);\n    return true;\n}",
                "expected_behavior" =>
                    "1. The searchUsers function should use parameterized queries to prevent SQL injection.\n2. The login form should include CSRF protection tokens.\n3. The displayUserProfile function should sanitize user data to prevent XSS attacks.\n4. The resetPassword function should use secure password hashing and not email plaintext passwords.",
                "current_behavior" =>
                    "1. The searchUsers function is vulnerable to SQL injection attacks.\n2. The login form lacks CSRF protection.\n3. The displayUserProfile function renders unsanitized user input, making it vulnerable to XSS.\n4. The resetPassword function uses plaintext passwords and insecure SQL queries.",
            ],
        ]);

        // Add Tasks for the Security Challenge
        Task::create([
            'challenge_id' => $securityChallenge->id,
            'name' => 'Fix SQL Injection Vulnerability',
            'description' => 'Correct the searchUsers function.',
            'instructions' => 'Refactor the `searchUsers` function provided in the challenge content to use prepared statements (parameterized queries) to prevent SQL injection. Submit the corrected PHP code snippet.',
            'points_reward' => 60,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check for use of prepared statements (e.g., PDO or MySQLi) and correct parameter binding.']),
            'order' => 1,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $securityChallenge->id,
            'name' => 'Implement CSRF Protection',
            'description' => 'Add CSRF token to the login form.',
            'instructions' => "Modify the `renderLoginForm` function to include a hidden input field containing a unique CSRF token. Explain how the token would be generated and validated on the server-side (you don't need to write the server-side validation code, just explain the process). Submit the modified `renderLoginForm` function code and the explanation.",
            'points_reward' => 70,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check for inclusion of hidden input for CSRF token and a reasonable explanation of generation/validation.']),
            'order' => 2,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $securityChallenge->id,
            'name' => 'Prevent XSS Attack',
            'description' => 'Sanitize user data in displayUserProfile.',
            'instructions' => 'Update the `displayUserProfile` function to properly sanitize the `name`, `bio`, and `website` fields before outputting them to prevent Cross-Site Scripting (XSS) attacks. Use appropriate PHP functions (e.g., `htmlspecialchars`). Submit the corrected PHP code snippet.',
            'points_reward' => 60,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check for use of functions like htmlspecialchars() on user-provided data before echoing.']),
            'order' => 3,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $securityChallenge->id,
            'name' => 'Secure Password Reset',
            'description' => 'Improve the password reset function.',
            'instructions' => 'Identify the security flaws in the `resetPassword` function. Describe how you would improve it using secure practices like password hashing (e.g., `password_hash()`) and secure token generation instead of emailing plain text passwords. Submit your explanation.',
            'points_reward' => 60,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check for identification of flaws (plaintext password, insecure query) and suggestion of secure alternatives (hashing, tokens).']),
            'order' => 4,
            'is_active' => true,
        ]);
        $securityChallenge->updatePointsReward();

        // 2. Algorithm Challenge - E-commerce Recommendation Engine
        $algoChallenge = Challenge::create([
            "name" => "Product Recommendation Algorithm",
            "description" =>
                "Design and implement a recommendation algorithm for an e-commerce website based on user purchase history and browsing patterns.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 0,
            "difficulty_level" => "advanced",
            "is_active" => true,
            "max_participants" => 30,
            "required_level" => 6,
            "challenge_type" => "algorithm",
            "time_limit" => 180,
            "programming_language" => "python",
            "tech_category" => "data_science",
            "category_id" => $categories["computer-science"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "An e-commerce company wants to improve its product recommendation system. Your task is to design and implement an algorithm that analyzes customer purchase history, browsing patterns, and product similarity to generate personalized product recommendations.\n\nYou are provided with three datasets: 1) user_purchase_history.csv - containing user IDs and their past purchases, 2) product_catalog.csv - containing product details including categories and attributes, and 3) user_browsing_data.csv - containing records of user browsing sessions.\n\nYour algorithm should generate a list of top 5 product recommendations for each user that maximizes the likelihood of purchase based on their behavior patterns and product relationships.",
                "algorithm_type" => "other",
                "example" =>
                    "Input:\nUser ID: 12345\nPurchase History: [ProductID: 101 (Wireless Headphones), ProductID: 203 (Smartphone Case), ProductID: 150 (Bluetooth Speaker)]\nBrowsing History: [ProductID: 205 (Phone Charger), ProductID: 180 (Smartwatch), ProductID: 110 (Wireless Earbuds)]\n\nExpected Output:\nRecommended Products for User 12345:\n1. ProductID: 190 (Power Bank) - Based on category similarity and complementary products\n2. ProductID: 112 (Noise Cancelling Headphones) - Based on product similarity\n3. ProductID: 185 (Fitness Tracker) - Based on browsing pattern\n4. ProductID: 210 (Screen Protector) - Based on complementary purchase\n5. ProductID: 155 (Portable Speaker) - Based on product category interest",
                "solution_approach" =>
                    "Your approach should consider implementing a hybrid recommendation system that combines collaborative filtering (analyzing purchase patterns of similar users) and content-based filtering (recommending items with similar attributes to ones the user has shown interest in). Consider using techniques such as cosine similarity for product relatedness, weighted scoring for recency of interactions, and potentially matrix factorization for uncovering latent features in user-product interactions. Your solution will be evaluated on recommendation relevance, algorithm efficiency, and implementation quality.",
            ],
        ]);

        // Add Tasks for Algorithm Challenge
        Task::create([
            'challenge_id' => $algoChallenge->id,
            'name' => 'Algorithm Design Document',
            'description' => 'Outline your chosen recommendation approach.',
            'instructions' => 'Submit a document (PDF or Markdown text) outlining the specific recommendation algorithm(s) you plan to implement (e.g., user-based collaborative filtering, item-based collaborative filtering, content-based filtering, hybrid approach). Describe the key steps, data preprocessing required, similarity metrics, and how you will combine different factors. Justify your choices.',
            'points_reward' => 100,
            'submission_type' => 'file',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Evaluate clarity of design, appropriateness of chosen algorithms, justification, and completeness of the description.']),
            'order' => 1,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $algoChallenge->id,
            'name' => 'Code Implementation',
            'description' => 'Implement the recommendation algorithm in Python.',
            'instructions' => 'Submit your Python code implementation as a .py file or a link to a Git repository (e.g., GitHub, GitLab). Your code should include functions to load data, preprocess it, calculate recommendations based on your design document, and output the top 5 recommendations for a given user ID. Ensure your code is well-commented and follows good programming practices.',
            'points_reward' => 150,
            'submission_type' => 'url',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Evaluate code correctness based on design doc, efficiency, readability, commenting, and adherence to Python best practices. Bonus for including unit tests.']),
            'order' => 2,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $algoChallenge->id,
            'name' => 'Results Analysis & Explanation',
            'description' => 'Explain the recommendations for a sample user.',
            'instructions' => "Run your algorithm for User ID 12345 (from the example). Submit the list of 5 recommended ProductIDs. Additionally, provide a brief explanation (text submission) for why each product was recommended based on your algorithm's logic and the user's history/browsing data.",
            'points_reward' => 50,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check if the generated recommendations match the expected output logic (even if exact IDs differ slightly based on implementation). Evaluate the clarity and logical consistency of the explanation for each recommendation.']),
            'order' => 3,
            'is_active' => true,
        ]);
        $algoChallenge->updatePointsReward();

        // ======= MATHEMATICS CHALLENGES =======

        // 8. Calculus Challenge
        $calculusChallenge = Challenge::create([
            "name" => "Calculus Integration and Applications",
            "description" =>
                "Solve complex integration problems and apply calculus to real-world physics and engineering scenarios.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 0,
            "difficulty_level" => "advanced",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 5,
            "challenge_type" => "problem_solving",
            "time_limit" => 120,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["mathematics"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your understanding of integral calculus and its applications. You will solve problems involving definite and indefinite integrals, applications of integration in physics and engineering, and area and volume calculations using multiple integration techniques.",
                "sections" => [
                    "Part 1: Evaluate the following integrals using appropriate techniques (substitution, integration by parts, partial fractions):\n1. ∫(x³e^x) dx\n2. ∫(ln(x)/x) dx\n3. ∫(1/(x²-4)) dx\n4. ∫(sin²(x)cos(x)) dx",
                    "Part 2: Applications of Integration:\n1. Find the area enclosed by y = x², y = 0, x = 0, and x = 3.\n2. Find the volume of the solid obtained by rotating the region bounded by y = x², y = 0, x = 0, and x = 2 about the x-axis.\n3. A particle moves along a straight line with velocity function v(t) = t² - 4t + 3 m/s. Find the total distance traveled by the particle during the time interval [0, 5].",
                    "Part 3: Real-world Application:\nA manufacturing company produces widgets at a rate of R(t) = 100 + 20t - 2t² units per hour, where t is measured in hours since production began. Set up and evaluate a definite integral to find the total number of widgets produced during the first 8 hours of production.",
                ],
                "evaluation_criteria" =>
                    "Your solutions will be evaluated on mathematical accuracy, proper application of integration techniques, clear step-by-step work, and correct interpretation of results in applied problems. For each problem, show all your work, including the integration technique chosen and intermediate steps.",
            ],
        ]);

        // Add Tasks for Calculus Challenge
        Task::create([
            'challenge_id' => $calculusChallenge->id,
            'name' => 'Part 1: Indefinite Integrals',
            'description' => 'Solve the four indefinite integrals.',
            'instructions' => 'Solve the four indefinite integrals listed in Part 1 of the challenge description. Show your step-by-step work for each, clearly indicating the integration technique used (e.g., substitution, integration by parts, partial fractions). Submit your solutions as text or an uploaded document (PDF).',
            'points_reward' => 100,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check for correct application of techniques, accuracy of integration, inclusion of constant of integration (+C), and clear work.']),
            'order' => 1,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $calculusChallenge->id,
            'name' => 'Part 2: Applications - Area',
            'description' => 'Calculate the area.',
            'instructions' => 'Calculate the area specified in Part 2, Problem 1. Set up the definite integral and show the evaluation steps. Submit the final numerical answer and your work.',
            'points_reward' => 40,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check correct integral setup, limits of integration, evaluation, and final answer (Area = 9).']),
            'order' => 2,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $calculusChallenge->id,
            'name' => 'Part 2: Applications - Volume',
            'description' => 'Calculate the volume of rotation.',
            'instructions' => 'Calculate the volume specified in Part 2, Problem 2 (rotation about x-axis). Use the appropriate method (disk/washer) and show the integral setup and evaluation. Submit the final numerical answer and your work.',
            'points_reward' => 50,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check correct method (disk), integral setup (π ∫[f(x)]² dx), limits, evaluation, and final answer (Volume = 32π/5).']),
            'order' => 3,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $calculusChallenge->id,
            'name' => 'Part 2: Applications - Distance Traveled',
            'description' => 'Calculate the total distance.',
            'instructions' => 'Calculate the total distance traveled by the particle as described in Part 2, Problem 3. Remember that total distance requires considering intervals where velocity is negative (∫|v(t)| dt). Show your work.',
            'points_reward' => 50,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check identification of intervals where v(t) changes sign, correct setup of integrals for each interval (using absolute value or splitting), evaluation, and final distance.']),
            'order' => 4,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $calculusChallenge->id,
            'name' => 'Part 3: Real-world Application',
            'description' => 'Calculate total widgets produced.',
            'instructions' => 'Set up and evaluate the definite integral to find the total number of widgets produced during the first 8 hours, as described in Part 3. Show the integral setup and evaluation steps.',
            'points_reward' => 40,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Check correct integral setup (∫ R(t) dt), limits (0 to 8), evaluation, and final answer.']),
            'order' => 5,
            'is_active' => true,
        ]);
        $calculusChallenge->updatePointsReward();

        // ======= SCIENCE CHALLENGES =======

        // 10. Physics Challenge
        Challenge::create([
            "name" => "Physics of Motion and Energy",
            "description" =>
                "Apply principles of mechanics, energy conservation, and Newton's laws to solve complex physics problems.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(12),
            "points_reward" => 260,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 45,
            "required_level" => 4,
            "challenge_type" => "problem_solving",
            "time_limit" => 120,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["physics"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your understanding of classical mechanics, including kinematics, dynamics, energy conservation, and rotational motion. You will apply physical principles to solve problems involving motion, forces, energy transformations, and mechanical systems.",
                "sections" => [
                    "Part 1: Kinematics and Dynamics\n1. A ball is thrown upward from the top of a 30-meter building with an initial velocity of 15 m/s. Calculate:\n   a) The maximum height reached by the ball relative to the ground\n   b) The time it takes to reach the ground\n   c) The velocity just before hitting the ground\n   (Use g = 9.8 m/s²)\n\n2. A 2 kg block slides down a frictionless inclined plane that makes an angle of 30° with the horizontal. If the block starts from rest, what is its acceleration and the force exerted by the plane on the block?",
                    "Part 2: Energy and Work\n1. A roller coaster car (mass 500 kg with passengers) starts from rest at a height of 40 meters. Calculate:\n   a) The speed at the bottom of the first drop (height = 5 meters)\n   b) The speed at the top of the next hill (height = 25 meters)\n   c) If the actual measured speed at the bottom is 25 m/s, calculate the energy lost to friction and determine the coefficient of friction\n\n2. A spring with spring constant k = 400 N/m is compressed by 0.15 meters. When released, it launches a 0.5 kg ball vertically. Calculate the maximum height reached by the ball.",
                    "Part 3: Rotational Motion\n1. A solid cylinder of mass 5 kg and radius 0.2 meters rolls without slipping down an inclined plane that makes an angle of 25° with the horizontal. Calculate:\n   a) The linear acceleration of the cylinder\n   b) The minimum coefficient of static friction needed to prevent slipping\n   (The moment of inertia of a solid cylinder about its center is I = ½MR²)",
                ],
                "evaluation_criteria" =>
                    "Your solutions will be evaluated on correct application of physical principles, mathematical accuracy, clear representation of problems using diagrams where appropriate, proper use of units, and complete step-by-step solutions showing all work.",
            ],
        ]);

        // Add Tasks for Physics Challenge
        $physicsChallenge = Challenge::where('name', 'Physics of Motion and Energy')->first(); // Re-fetch to ensure we have the ID
        if ($physicsChallenge) {
            Task::create([
                'challenge_id' => $physicsChallenge->id,
                'name' => 'Part 1: Kinematics - Upward Throw',
                'description' => 'Solve the kinematics problem for the ball thrown upward (max height, time to ground, final velocity).',
                'instructions' => "Solve Part 1, Problem 1 (a, b, c) using kinematic equations. Show all steps and calculations. Use g = 9.8 m/s². Submit your work and final answers.",
                'points_reward' => 70,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check application of kinematic equations, correct formulas, steps, units, and final answers.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $physicsChallenge->id,
                'name' => 'Part 1: Dynamics - Inclined Plane',
                'description' => 'Calculate acceleration and normal force for the block on the frictionless inclined plane.',
                'instructions' => "Solve Part 1, Problem 2. Draw a free-body diagram, apply Newton's second law, and calculate the acceleration and the normal force. Show all work. Submit your diagram, calculations, and final answers.",
                'points_reward' => 50,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check free-body diagram, application of Newton\'s laws, vector components, and final answers with units.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $physicsChallenge->id,
                'name' => 'Part 2: Energy - Roller Coaster',
                'description' => 'Apply energy conservation to calculate speeds and analyze energy loss for the roller coaster.',
                'instructions' => "Solve Part 2, Problem 1 (a, b, c). Use the principle of conservation of energy for (a) and (b). For (c), calculate energy lost to friction and the coefficient if applicable. Show all work. Submit your calculations and answers.",
                'points_reward' => 80,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check application of conservation of energy (PE + KE), calculation of work done by friction, and coefficient of friction. Verify steps and units.']),
                'order' => 3,
                'is_active' => true,
            ]);
             Task::create([
                'challenge_id' => $physicsChallenge->id,
                'name' => 'Part 2: Energy - Spring Launch',
                'description' => 'Calculate the maximum height reached by a ball launched by a compressed spring.',
                'instructions' => "Solve Part 2, Problem 2. Use conservation of energy (elastic potential energy to gravitational potential energy). Show your setup and calculations. Submit your work and final answer.",
                'points_reward' => 60, // Reduced from original total
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check application of conservation of energy (elastic PE to gravitational PE), correct formulas, calculation, and final answer with units.']),
                'order' => 4,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $physicsChallenge->id,
                'name' => 'Part 3: Rotational Motion - Rolling Cylinder',
                'description' => 'Calculate linear acceleration and minimum friction coefficient for a cylinder rolling down an incline.',
                'instructions' => "Solve Part 3, Problem 1 (a, b). Apply principles of rotational dynamics and energy conservation for rolling motion. Show free-body diagram, equations of motion (linear and rotational), and calculations. Submit your work and answers.",
                'points_reward' => 90, // Adjusted points
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check application of rotational dynamics (torque, moment of inertia), energy conservation for rolling, condition for rolling without slipping (a = αR), friction calculation, and final answers with units.']),
                'order' => 5,
                'is_active' => true,
            ]);
            $physicsChallenge->updatePointsReward(); // Update total points based on tasks
        }

        // 11. Chemistry Challenge
        Challenge::create([
            "name" => "Chemical Reactions and Stoichiometry",
            "description" =>
                "Balance complex chemical equations and solve stoichiometry problems involving limiting reagents, percent yield, and solution chemistry.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 240,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 3,
            "challenge_type" => "problem_solving",
            "time_limit" => 90,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["chemistry"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your understanding of chemical reactions, stoichiometry, limiting reagents, and solution chemistry. You will balance equations, calculate quantities in chemical reactions, and solve problems involving concentration and dilutions.",
                "sections" => [
                    "Part 1: Balancing Chemical Equations\nBalance the following chemical equations:\n1. ___ Fe + ___ O₂ → ___ Fe₂O₃\n2. ___ KMnO₄ + ___ HCl → ___ KCl + ___ MnCl₂ + ___ H₂O + ___ Cl₂\n3. ___ C₃H₈ + ___ O₂ → ___ CO₂ + ___ H₂O\n4. ___ NH₄NO₃ → ___ N₂O + ___ H₂O\n5. ___ Al + ___ Fe₂O₃ → ___ Al₂O₃ + ___ Fe (thermite reaction)",
                    "Part 2: Stoichiometry\n1. When 25.0 g of calcium carbonate (CaCO₃) reacts with excess hydrochloric acid (HCl) according to the reaction: CaCO₃ + 2 HCl → CaCl₂ + H₂O + CO₂, what mass of carbon dioxide is produced?\n\n2. In the reaction: 2 Al + 3 Cl₂ → 2 AlCl₃, if you start with 13.5 g of aluminum and 35.5 g of chlorine gas, determine:\n   a) The limiting reagent\n   b) The theoretical yield of aluminum chloride in grams\n   c) If 32.0 g of AlCl₃ is actually produced, calculate the percent yield",
                    "Part 3: Solution Chemistry\n1. How would you prepare 500 mL of a 0.25 M H₂SO₄ solution from a stock solution that is 98% H₂SO₄ by mass with a density of 1.84 g/mL?\n\n2. A buffer solution is prepared by mixing 125 mL of 0.20 M acetic acid (CH₃COOH) with 75 mL of 0.15 M sodium acetate (CH₃COONa). Calculate the pH of this buffer solution. (Ka of acetic acid = 1.8 × 10⁻⁵)",
                ],
                "evaluation_criteria" =>
                    "Your solutions will be evaluated on correct balancing of chemical equations, accurate stoichiometric calculations, proper setup and conversion of units, clear step-by-step work, and correct application of chemical principles. Show all calculations, including molar masses used.",
            ],
        ]);

        // Add Tasks for Chemistry Challenge
        $chemistryChallenge = Challenge::where('name', 'Chemical Reactions and Stoichiometry')->first();
        if ($chemistryChallenge) {
            Task::create([
                'challenge_id' => $chemistryChallenge->id,
                'name' => 'Part 1: Balancing Equations',
                'description' => 'Balance the five chemical equations provided in Part 1.',
                'instructions' => 'Balance each of the 5 chemical equations listed in Part 1. Ensure the number of atoms for each element is the same on both sides. Submit the balanced equations.',
                'points_reward' => 50, // 10 points each
                'submission_type' => 'text',
                'evaluation_type' => 'manual', // Could potentially be automated with specific formatting rules
                'evaluation_details' => json_encode(['guidelines' => 'Check coefficients for correctness in all 5 equations.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $chemistryChallenge->id,
                'name' => 'Part 2: Stoichiometry - CO2 Production',
                'description' => 'Calculate the mass of CO₂ produced from the reaction of CaCO₃ with HCl.',
                'instructions' => 'Solve Part 2, Problem 1. Calculate the molar mass of CaCO₃, convert grams to moles, use the stoichiometry of the balanced equation to find moles of CO₂, and convert moles of CO₂ to grams. Show all work and units.',
                'points_reward' => 40,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check molar mass calculations, mole conversions, stoichiometric ratio usage, and final mass calculation with units.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $chemistryChallenge->id,
                'name' => 'Part 2: Stoichiometry - Limiting Reagent & Yield',
                'description' => 'Determine the limiting reagent, theoretical yield, and percent yield for the reaction of Al and Cl₂.',
                'instructions' => 'Solve Part 2, Problem 2 (a, b, c). Calculate moles of Al and Cl₂, determine the limiting reagent, calculate the theoretical yield of AlCl₃ in grams based on the limiting reagent, and calculate the percent yield using the actual yield provided. Show all calculations.',
                'points_reward' => 70,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check mole calculations, correct identification of limiting reagent, correct theoretical yield calculation, and correct percent yield calculation.']),
                'order' => 3,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $chemistryChallenge->id,
                'name' => 'Part 3: Solution Chemistry - Dilution',
                'description' => 'Calculate how to prepare a diluted H₂SO₄ solution from a concentrated stock solution.',
                'instructions' => 'Solve Part 3, Problem 1. Calculate the molarity of the stock solution using its percentage by mass and density. Then use the dilution formula (M1V1 = M2V2) to find the volume of stock solution needed. Describe the steps to prepare the final solution. Show all calculations.',
                'points_reward' => 40,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check calculation of stock solution molarity, correct use of dilution formula, calculation of required volume, and description of preparation steps.']),
                'order' => 4,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $chemistryChallenge->id,
                'name' => 'Part 3: Solution Chemistry - Buffer pH',
                'description' => 'Calculate the pH of the buffer solution prepared by mixing acetic acid and sodium acetate.',
                'instructions' => 'Solve Part 3, Problem 2. Calculate the initial moles of acetic acid and sodium acetate. Use the Henderson-Hasselbalch equation (pH = pKa + log([A-]/[HA])) to calculate the pH of the buffer. Use the provided Ka value. Show all calculations.',
                'points_reward' => 40,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check calculation of moles, calculation of pKa, correct application of Henderson-Hasselbalch equation, and final pH value.']),
                'order' => 5,
                'is_active' => true,
            ]);
            $chemistryChallenge->updatePointsReward();
        }

        // 12. Biology Challenge
        Challenge::create([
            "name" => "Cellular Processes and Genetics",
            "description" =>
                "Analyze cellular mechanisms, genetic inheritance patterns, and molecular biology processes.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 230,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 45,
            "required_level" => 3,
            "challenge_type" => "problem_solving",
            "time_limit" => 100,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["biology"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your understanding of cellular biology, genetics, inheritance patterns, and molecular biology. You will analyze biological processes, solve genetic problems, and interpret experimental data.",
                "sections" => [
                    "Part 1: Cellular Biology\n1. Compare and contrast the processes of mitosis and meiosis in terms of:\n   a) Purpose\n   b) Number of divisions\n   c) Number and genetic composition of daughter cells\n   d) Significance in multicellular organisms\n\n2. Describe the role of ATP in cellular metabolism and explain the processes by which cells produce ATP during aerobic and anaerobic respiration. Include the locations of these processes within the cell and the approximate ATP yield for each.",
                    "Part 2: Genetics and Inheritance\n1. In pea plants, yellow seed color (Y) is dominant to green (y), and round seed shape (R) is dominant to wrinkled (r). A plant heterozygous for both traits is crossed with a plant that has green, wrinkled seeds.\n   a) Write the genotypes of both parent plants\n   b) Determine the possible gametes each parent can produce\n   c) Construct a Punnett square for this cross\n   d) Calculate the probability of obtaining offspring with yellow, wrinkled seeds\n\n2. A colorblind woman marries a man with normal vision. Colorblindness is an X-linked recessive trait.\n   a) What are the genotypes of the parents?\n   b) What is the probability that their first son will be colorblind?\n   c) What is the probability that their first daughter will be colorblind?",
                    "Part 3: Molecular Biology\n1. Transcribe and translate the following DNA sequence into a polypeptide: 5'-ATGCCAGACTTAGCAAAG-3'\n   (Use the genetic code table provided)\n\n2. Describe the process of DNA replication, including the major enzymes involved and the significance of the 5' to 3' direction of synthesis. Explain how the two strands of DNA are replicated differently.",
                ],
                "evaluation_criteria" =>
                    "Your responses will be evaluated on scientific accuracy, completeness of explanations, correct application of biological principles, proper use of terminology, and logical organization of ideas. For genetic problems, show all work including genotypes, phenotypes, and probability calculations.",
            ],
        ]);

        // Add Tasks for Biology Challenge
        $biologyChallenge = Challenge::where('name', 'Cellular Processes and Genetics')->first();
        if ($biologyChallenge) {
            Task::create([
                'challenge_id' => $biologyChallenge->id,
                'name' => 'Part 1: Mitosis vs Meiosis Comparison',
                'description' => 'Compare and contrast mitosis and meiosis based on the given criteria.',
                'instructions' => "Address Part 1, Problem 1 (a, b, c, d). Provide clear and accurate comparisons for purpose, number of divisions, daughter cell characteristics, and significance. Submit your written comparison.",
                'points_reward' => 50,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate accuracy and completeness of comparison across all four points (a-d). Check clarity and use of correct terminology.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $biologyChallenge->id,
                'name' => 'Part 1: ATP Production Explanation',
                'description' => 'Describe the role of ATP and explain aerobic/anaerobic respiration processes for ATP production.',
                'instructions' => "Address Part 1, Problem 2. Explain ATP's role, describe the main stages of aerobic respiration (glycolysis, Krebs cycle, oxidative phosphorylation) and anaerobic respiration (fermentation), including locations and approximate ATP yields. Submit your explanation.",
                'points_reward' => 50,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check accuracy of ATP role, description of respiration pathways, locations (cytoplasm, mitochondria), and relative ATP yields.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $biologyChallenge->id,
                'name' => 'Part 2: Dihybrid Cross Problem',
                'description' => 'Solve the pea plant dihybrid cross genetics problem.',
                'instructions' => "Address Part 2, Problem 1 (a, b, c, d). Write parent genotypes, determine possible gametes, construct the Punnett square, and calculate the probability of offspring with yellow, wrinkled seeds. Show all work. Submit your genotypes, gametes, Punnett square, and probability.",
                'points_reward' => 50,
                'submission_type' => 'text', // Could potentially upload an image of the Punnett square
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check correctness of genotypes, gametes, Punnett square construction, and final probability calculation (should be 3/16 or 18.75%).']),
                'order' => 3,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $biologyChallenge->id,
                'name' => 'Part 2: X-Linked Inheritance Problem',
                'description' => 'Solve the colorblindness X-linked recessive inheritance problem.',
                'instructions' => "Address Part 2, Problem 2 (a, b, c). Determine parent genotypes, calculate the probability of their first son being colorblind, and the probability of their first daughter being colorblind. Use standard notation for X-linked traits. Show your work. Submit genotypes and probabilities.",
                'points_reward' => 40,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check correctness of parent genotypes (e.g., XcXc and XCY), and probabilities (Son: 100%, Daughter: 0%).']),
                'order' => 4,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $biologyChallenge->id,
                'name' => 'Part 3: Transcription and Translation',
                'description' => 'Transcribe and translate the given DNA sequence into a polypeptide.',
                'instructions' => "Address Part 3, Problem 1. Transcribe the DNA sequence (5'-ATGCCAGACTTAGCAAAG-3') into mRNA, then use a standard genetic code table to translate the mRNA sequence into the corresponding amino acid sequence (polypeptide). Assume the sequence starts with the start codon. Submit the mRNA sequence and the amino acid sequence.",
                'points_reward' => 40,
                'submission_type' => 'text',
                'evaluation_type' => 'manual', // Could be automated with a specific genetic code table
                'evaluation_details' => json_encode(['guidelines' => 'Check correct transcription (A->U, T->A, G->C, C->G) and translation based on standard genetic code (e.g., mRNA: AUG CCA GAC UUA GCA AAG -> Polypeptide: Met-Pro-Asp-Leu-Ala-Lys).']),
                'order' => 5,
                'is_active' => true,
            ]);
             Task::create([
                'challenge_id' => $biologyChallenge->id,
                'name' => 'Part 3: DNA Replication Explanation',
                'description' => 'Describe the process of DNA replication, including enzymes and strand differences.',
                'instructions' => "Address Part 3, Problem 2. Describe DNA replication, mentioning key enzymes (helicase, primase, DNA polymerase, ligase), the 5' to 3' synthesis direction, and the difference between leading and lagging strand replication (Okazaki fragments). Submit your explanation.",
                'points_reward' => 50, // Adjusted points
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check accuracy and completeness of explanation, mentioning key enzymes, directionality, leading/lagging strands, and Okazaki fragments.']),
                'order' => 6,
                'is_active' => true,
            ]);
            $biologyChallenge->updatePointsReward();
        }

        // ======= HUMANITIES CHALLENGES =======

        // 13. History Challenge
        $historyChallenge = Challenge::create([
            "name" => "World War II: Critical Analysis",
            "description" =>
                "Analyze key events, decisions, and consequences of World War II through primary sources and historical perspectives.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(15),
            "points_reward" => 0,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 50,
            "required_level" => 3,
            "challenge_type" => "essay",
            "time_limit" => 150,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["history"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your ability to analyze historical events, evaluate primary sources, and construct evidence-based arguments about World War II. You will critically examine multiple perspectives on key decisions and events, and assess their short and long-term impacts.",
                "sections" => [
                    "Part 1: Document Analysis\nRead the following primary source excerpts related to World War II:\n1. Winston Churchill's \"Blood, Toil, Tears and Sweat\" speech (May 13, 1940)\n2. Franklin D. Roosevelt's \"Day of Infamy\" speech (December 8, 1941)\n3. Harry S. Truman's statement on the dropping of the atomic bomb (August 6, 1945)\n4. Joseph Stalin's Order No. 227 \"Not One Step Back!\" (July 28, 1942)\n\nFor each document:\na) Identify the historical context in which it was created\nb) Analyze the author's purpose and intended audience\nc) Evaluate the document's significance in shaping public opinion or policy",
                    "Part 2: Historical Analysis Essay\nWrite a well-structured essay addressing the following question:\n\n\"To what extent were the Allied and Axis powers' decisions during World War II shaped by ideological factors versus practical military and economic considerations?\"\n\nYour essay should:\n- Develop a clear thesis statement\n- Examine at least three major decisions or policies from different nations\n- Incorporate evidence from primary and secondary sources\n- Consider multiple perspectives and counterarguments\n- Evaluate short and long-term consequences\n- Draw reasoned conclusions about the relative importance of ideology versus practicality",
                    "Part 3: Historical Interpretation\nHistorians have debated whether the Cold War was an inevitable consequence of World War II alliance structures and ideological differences, or whether it resulted from specific post-war policy choices.\n\nWrite a response that:\n- Summarizes two contrasting historical interpretations of the origins of the Cold War\n- Evaluates the evidence supporting each interpretation\n- Analyzes how these interpretations have evolved over time\n- Presents your own evidence-based conclusion about the relationship between World War II and the Cold War",
                ],
                "evaluation_criteria" =>
                    "Your work will be evaluated on historical accuracy, depth of analysis, effective use of evidence, consideration of multiple perspectives, logical organization, clarity of expression, and strength of argumentation. All claims should be supported with specific historical evidence, and sources should be properly cited.",
            ],
        ]);

        // Add Tasks for History Challenge
        Task::create([
            'challenge_id' => $historyChallenge->id,
            'name' => 'Part 1: Document Analysis',
            'description' => 'Analyze the four primary source documents.',
            'instructions' => "For each of the four primary source documents listed in Part 1, provide an analysis covering: a) Historical context, b) Author's purpose and audience, c) Significance. Submit your analysis as a single text entry or an uploaded document.",
            'points_reward' => 80,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Evaluate depth of analysis, accuracy of context, understanding of purpose/audience, and assessment of significance for each document.']),
            'order' => 1,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $historyChallenge->id,
            'name' => 'Part 2: Historical Analysis Essay',
            'description' => 'Write the main essay on ideology vs. practicality.',
            'instructions' => 'Write a well-structured essay addressing the question in Part 2: \"To what extent were the Allied and Axis powers\' decisions during World War II shaped by ideological factors versus practical military and economic considerations?\" Follow all essay requirements outlined in the challenge description. Submit your essay as text or an uploaded document.',
            'points_reward' => 100,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['rubric' => [
                'Thesis Statement' => 15,
                'Argumentation & Evidence' => 35,
                'Analysis (Ideology vs Practicality)' => 30,
                'Structure & Clarity' => 10,
                'Addressing Counterarguments' => 10
            ]]),
            'order' => 2,
            'is_active' => true,
        ]);
        Task::create([
            'challenge_id' => $historyChallenge->id,
            'name' => 'Part 3: Historical Interpretation',
            'description' => 'Analyze interpretations of Cold War origins.',
            'instructions' => 'Write a response addressing the prompt in Part 3 regarding the origins of the Cold War. Summarize two contrasting interpretations, evaluate their evidence, discuss their evolution, and present your conclusion. Submit your response as text or an uploaded document.',
            'points_reward' => 60,
            'submission_type' => 'text',
            'evaluation_type' => 'manual',
            'evaluation_details' => json_encode(['guidelines' => 'Evaluate understanding of historical interpretations, ability to summarize and evaluate evidence, analysis of historiography, and strength of conclusion.']),
            'order' => 3,
            'is_active' => true,
        ]);
        $historyChallenge->updatePointsReward();

        // 14. Literature Challenge
        Challenge::create([
            "name" => "Literary Analysis and Comparative Literature",
            "description" =>
                "Analyze literary works across different time periods and cultures, examining themes, techniques, and historical contexts.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 220,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 45,
            "required_level" => 3,
            "challenge_type" => "essay",
            "time_limit" => 120,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["literature"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your ability to analyze literary texts, compare works across different periods and cultures, and construct well-reasoned arguments about literary themes and techniques. You will demonstrate critical reading skills and an understanding of historical and cultural contexts.",
                "sections" => [
                    "Part 1: Close Reading Analysis\nAnalyze the following excerpt from James Joyce's 'The Dead' (the final passage):\n\n\"A few light taps upon the pane made him turn to the window. It had begun to snow again. He watched sleepily the flakes, silver and dark, falling obliquely against the lamplight. The time had come for him to set out on his journey westward. Yes, the newspapers were right: snow was general all over Ireland. It was falling on every part of the dark central plain, on the treeless hills, falling softly upon the Bog of Allen and, farther westward, softly falling into the dark mutinous Shannon waves. It was falling, too, upon every part of the lonely churchyard on the hill where Michael Furey lay buried. It lay thickly drifted on the crooked crosses and headstones, on the spears of the little gate, on the barren thorns. His soul swooned slowly as he heard the snow falling faintly through the universe and faintly falling, like the descent of their last end, upon all the living and the dead.\"\n\nIn your analysis:\n- Examine the use of imagery, symbolism, and language\n- Discuss how this passage relates to the themes of the story\n- Analyze the narrative perspective and tone\n- Explain how this conclusion creates meaning in the text",
                    "Part 2: Comparative Analysis Essay\nWrite a comparative essay on ONE of the following pairs of texts:\n\nOption A: Shakespeare's \"Hamlet\" and Chinua Achebe's \"Things Fall Apart\"\nOption B: Emily Brontë's \"Wuthering Heights\" and Gabriel García Márquez's \"One Hundred Years of Solitude\"\nOption C: George Orwell's \"1984\" and Margaret Atwood's \"The Handmaid's Tale\"\n\nYour essay should:\n- Develop a clear thesis comparing a specific aspect of both works (e.g., treatment of power, representation of gender, narrative structure)\n- Analyze how each author's cultural and historical context influences their approach\n- Provide close textual analysis with specific examples from both works\n- Discuss similarities and differences in themes, techniques, and perspectives\n- Draw meaningful conclusions about what this comparison reveals",
                    "Part 3: Literary Movements\nSelect ONE literary movement from the list below and write a response that:\n- Describes the key characteristics and historical context of the movement\n- Analyzes how two representative works exemplify the movement's principles\n- Evaluates the movement's influence on subsequent literature\n\nLiterary Movements:\n- Romanticism\n- Modernism\n- Postcolonial Literature\n- Magical Realism\n- The Harlem Renaissance",
                ],
                "evaluation_criteria" =>
                    "Your work will be evaluated on depth of literary analysis, understanding of historical and cultural contexts, effective use of textual evidence, clarity of argumentation, consideration of literary techniques and devices, and overall organization and writing quality. All citations from texts should be properly integrated and referenced.",
            ],
        ]);

        // Add Tasks for Literature Challenge
        $literatureChallenge = Challenge::where('name', 'Literary Analysis and Comparative Literature')->first();
        if ($literatureChallenge) {
            Task::create([
                'challenge_id' => $literatureChallenge->id,
                'name' => "Part 1: Close Reading of Joyce's 'The Dead'",
                'description' => "Analyze the provided excerpt from James Joyce's 'The Dead'.",
                'instructions' => "Write a close reading analysis of the final passage of Joyce's 'The Dead'. Address imagery, symbolism, language, themes, narrative perspective/tone, and how the conclusion creates meaning. Submit your analysis (approx. 300-500 words).",
                'points_reward' => 70,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate depth of analysis on specified literary elements, connection to themes, understanding of narrative technique, and clarity of writing.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $literatureChallenge->id,
                'name' => 'Part 2: Comparative Analysis Essay',
                'description' => 'Write a comparative essay on one of the provided pairs of texts.',
                'instructions' => "Choose ONE pair of texts (A, B, or C) and write a comparative essay addressing the requirements outlined in Part 2. Develop a clear thesis, use textual evidence, analyze context, discuss similarities/differences, and draw conclusions. Submit your essay (approx. 800-1000 words).",
                'points_reward' => 80,
                'submission_type' => 'text', // Or file upload
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate strength of thesis, quality of comparison, use of textual evidence from both works, contextual analysis, argumentation, structure, and writing clarity.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $literatureChallenge->id,
                'name' => 'Part 3: Literary Movement Analysis',
                'description' => 'Analyze one literary movement from the list provided.',
                'instructions' => "Select ONE literary movement from the list. Write a response describing its characteristics and context, analyzing how two representative works exemplify it, and evaluating its influence. Submit your analysis (approx. 400-600 words).",
                'points_reward' => 70,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate understanding of the chosen movement, accuracy of characteristics/context, quality of analysis of representative works, assessment of influence, and clarity.']),
                'order' => 3,
                'is_active' => true,
            ]);
            $literatureChallenge->updatePointsReward();
        }

        // 15. Geography Challenge
        Challenge::create([
            "name" => "Global Geography and Human-Environment Interaction",
            "description" =>
                "Analyze geographical patterns, human-environment relationships, and contemporary global challenges through spatial analysis.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(12),
            "points_reward" => 210,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 45,
            "required_level" => 2,
            "challenge_type" => "problem_solving",
            "time_limit" => 100,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["geography"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your understanding of physical and human geography, spatial patterns, and the complex relationships between human societies and their environments. You will analyze geographical data, interpret maps, and evaluate contemporary global challenges.",
                "sections" => [
                    "Part 1: Physical Geography\n1. Examine the provided climate data and diagrams for locations A, B, C, and D:\n   a) Identify the Köppen climate classification for each location\n   b) Explain the primary factors influencing each climate type\n   c) Predict how climate change might affect each location by 2050\n\n2. Using the topographic map provided:\n   a) Identify three different landforms and explain their likely formation processes\n   b) Calculate the gradient between points X and Y\n   c) Determine the best route for a new road connecting towns P and Q, considering both physical geography and environmental impact",
                    "Part 2: Human Geography Case Study\nExamine the demographic, economic, and urban development data for Country Z from 1970-2020:\n\n1. Analyze the key demographic transitions and their relationship to economic development\n2. Evaluate the patterns of urbanization and rural-urban migration\n3. Identify three major challenges resulting from these changes\n4. Propose evidence-based solutions that address these challenges while promoting sustainable development\n5. Compare Country Z's experience with one other country in a different region",
                    "Part 3: Global Issues and Interconnections\nSelect ONE of the following global issues:\n- Water scarcity and management\n- Food security and agricultural systems\n- Energy resources and sustainability\n- Migration and population displacement\n\nFor your chosen issue:\n1. Analyze its geographic patterns and variations across regions\n2. Explain how physical and human geographic factors contribute to the issue\n3. Evaluate the interconnections between this issue and global economic systems\n4. Assess two contrasting approaches to addressing the issue\n5. Create a simple GIS-style map that visualizes key aspects of the issue",
                ],
                "evaluation_criteria" =>
                    "Your responses will be evaluated on geographical accuracy, spatial analysis skills, appropriate use of geographical terminology, ability to interpret data and maps, understanding of human-environment relationships, and evidence-based reasoning. Maps, diagrams, and data visualizations should be clearly labeled and properly referenced.",
            ],
        ]);

        // Add Tasks for Geography Challenge
        $geographyChallenge = Challenge::where('name', 'Global Geography and Human-Environment Interaction')->first();
        if ($geographyChallenge) {
            Task::create([
                'challenge_id' => $geographyChallenge->id,
                'name' => 'Part 1: Physical Geography - Climate Analysis',
                'description' => 'Analyze climate data for four locations (Köppen classification, influencing factors, climate change impact).',
                'instructions' => "Address Part 1, Problem 1 (a, b, c). Assume climate data/diagrams are provided externally. Identify Köppen types, explain factors, and predict climate change effects. Submit your analysis.",
                'points_reward' => 50,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate correct Köppen classification, understanding of climate controls, and plausible climate change impact prediction based on location/type.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $geographyChallenge->id,
                'name' => 'Part 1: Physical Geography - Topographic Map Analysis',
                'description' => 'Analyze a topographic map (identify landforms, calculate gradient, determine best route).',
                'instructions' => "Address Part 1, Problem 2 (a, b, c). Assume a topographic map is provided externally. Identify landforms, calculate gradient between X and Y, and justify the best road route between P and Q. Submit your analysis and calculations.",
                'points_reward' => 50,
                'submission_type' => 'text', // Could include file upload for annotated map
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate correct landform identification/formation, accurate gradient calculation, and well-justified route selection considering terrain and environmental factors.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $geographyChallenge->id,
                'name' => 'Part 2: Human Geography Case Study',
                'description' => 'Analyze demographic, economic, and urban data for Country Z and compare with another country.',
                'instructions' => "Address Part 2 (Problems 1-5). Assume data for Country Z is provided. Analyze transitions, urbanization, challenges, propose solutions, and compare with another country. Submit your comprehensive analysis.",
                'points_reward' => 60,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate depth of analysis of demographic/economic/urban trends, identification of challenges, feasibility of solutions, and quality of comparison with another country.']),
                'order' => 3,
                'is_active' => true,
            ]);
             Task::create([
                'challenge_id' => $geographyChallenge->id,
                'name' => 'Part 3: Global Issues Analysis and Map',
                'description' => 'Analyze a chosen global issue (patterns, factors, interconnections, approaches) and create a map.',
                'instructions' => "Address Part 3 (Problems 1-5). Choose ONE global issue. Analyze its geography, contributing factors, global interconnections, and contrasting approaches. Create a simple GIS-style map visualizing an aspect of the issue. Submit your analysis and map (as file upload or embedded image).",
                'points_reward' => 50, // Adjusted points
                'submission_type' => 'file', // For the map primarily, analysis can be text
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate depth of geographical analysis of the chosen issue, understanding of interconnections, assessment of approaches, and clarity/relevance of the submitted map.']),
                'order' => 4,
                'is_active' => true,
            ]);
            $geographyChallenge->updatePointsReward();
        }

        // ======= LANGUAGE ARTS CHALLENGES =======

        // 16. Essay Writing Challenge
        Challenge::create([
            "name" => "Argumentative Essay: Contemporary Issues",
            "description" =>
                "Research and write a compelling argumentative essay on a contemporary social, political, or ethical issue.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(10),
            "points_reward" => 200,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 60,
            "required_level" => 2,
            "challenge_type" => "essay",
            "time_limit" => 120,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["english"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your ability to construct a well-reasoned argumentative essay on a contemporary issue. You will develop a clear thesis, support it with evidence, address counterarguments, and present your ideas in a cohesive, persuasive manner.",
                "sections" => [
                    "Instructions:\nSelect ONE of the following contemporary issues and write a well-structured argumentative essay that takes a clear position on the topic:\n\n1. Should social media platforms be held legally responsible for the content users post on their sites?\n2. Is universal basic income a viable solution to address economic inequality?\n3. Should standardized testing be eliminated from college admissions processes?\n4. Does artificial intelligence pose more benefits or risks to society?\n5. Should genetically modified organisms (GMOs) be more strictly regulated?",
                    "Essay Requirements:\n1. Introduction with a clear thesis statement that presents your position\n2. Body paragraphs that present at least three main arguments supporting your position\n3. At least one paragraph addressing and refuting counterarguments\n4. Evidence from at least four credible sources to support your arguments\n5. A conclusion that synthesizes your arguments and reinforces your position\n6. Proper citations in MLA or APA format\n7. Length: 1000-1250 words",
                    "Writing Process Requirements:\n1. Before writing your essay, create an outline showing your thesis, main arguments, counterarguments, and conclusion\n2. Include a brief annotated bibliography of your sources\n3. After completing your essay, write a short reflection (200-250 words) discussing your writing process, challenges you encountered, and how you addressed them",
                ],
                "evaluation_criteria" =>
                    "Your essay will be evaluated on clarity of thesis, strength of argumentation, use of evidence, effective organization, addressing of counterarguments, writing mechanics (grammar, spelling, punctuation), stylistic effectiveness, proper citation of sources, and overall persuasiveness. The strength of your position is less important than how well you construct and support your argument.",
            ],
        ]);

        // Add Tasks for Essay Writing Challenge
        $essayChallenge = Challenge::where('name', 'Argumentative Essay: Contemporary Issues')->first();
        if ($essayChallenge) {
             Task::create([
                'challenge_id' => $essayChallenge->id,
                'name' => 'Essay Outline and Annotated Bibliography',
                'description' => 'Submit an outline for your argumentative essay and an annotated bibliography of your sources.',
                'instructions' => "Choose ONE essay topic. Create a detailed outline including your thesis, main arguments (with planned evidence), counterarguments, and conclusion structure. Also, provide an annotated bibliography for at least four credible sources, briefly summarizing each and explaining its relevance. Submit as a single document.",
                'points_reward' => 50,
                'submission_type' => 'file', // Or text
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate clarity and completeness of the outline structure, logical flow of arguments, and quality/relevance of sources and annotations in the bibliography.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $essayChallenge->id,
                'name' => 'Argumentative Essay Submission',
                'description' => 'Submit the full argumentative essay based on your chosen topic and outline.',
                'instructions' => "Write the full argumentative essay (1000-1250 words) following the requirements: clear thesis, supported arguments, refuted counterarguments, evidence from 4+ sources, conclusion, and proper MLA or APA citation. Submit the final essay.",
                'points_reward' => 100,
                'submission_type' => 'file', // Or text
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate based on the main criteria: thesis, argumentation, evidence, organization, counterarguments, mechanics, style, citation, and persuasiveness.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $essayChallenge->id,
                'name' => 'Writing Process Reflection',
                'description' => 'Submit a short reflection on your essay writing process.',
                'instructions' => "Write a short reflection (200-250 words) discussing your writing process for this essay. Mention challenges you faced (e.g., research, structuring arguments, finding sources) and how you addressed them. Submit your reflection.",
                'points_reward' => 50,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate the thoughtfulness and insightfulness of the reflection on the writing process, including challenges and strategies.']),
                'order' => 3,
                'is_active' => true,
            ]);
            $essayChallenge->updatePointsReward();
        }

        // 17. Foreign Language Challenge
        Challenge::create([
            "name" => "Spanish Language Communication Skills",
            "description" =>
                "Demonstrate Spanish language proficiency through reading comprehension, writing, and cultural analysis.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(12),
            "points_reward" => 220,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 3,
            "challenge_type" => "language",
            "time_limit" => 120,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["languages"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "Este desafío evalúa tu dominio del español a través de la comprensión de lectura, la expresión escrita y el análisis cultural. Demostrarás tu capacidad para entender textos en español, comunicar ideas claramente y analizar aspectos culturales del mundo hispanohablante.",
                "sections" => [
                    "Parte 1: Comprensión de Lectura\nLee el siguiente texto sobre la importancia de la diversidad lingüística en América Latina y responde a las preguntas en español:\n\n[Text about linguistic diversity in Latin America]\n\n1. ¿Cuál es la idea principal del texto?\n2. ¿Qué desafíos enfrentan las lenguas indígenas según el autor?\n3. ¿Cómo se relaciona la diversidad lingüística con la identidad cultural?\n4. ¿Qué soluciones propone el autor para preservar las lenguas en peligro de extinción?\n5. ¿Estás de acuerdo con la perspectiva del autor? Justifica tu respuesta.",
                    "Parte 2: Expresión Escrita\nEscribe un ensayo en español de 350-450 palabras sobre UNO de los siguientes temas:\n\nOpción A: El impacto de la tecnología en las relaciones personales en el siglo XXI\nOpción B: Los desafíos ambientales más urgentes para los países hispanohablantes\nOpción C: La importancia del bilingüismo en el mundo globalizado\n\nTu ensayo debe incluir:\n- Una introducción con una tesis clara\n- Al menos tres argumentos principales con ejemplos\n- Una conclusión que sintetice tus ideas\n- Uso correcto de gramática, vocabulario variado y conectores para crear un texto cohesivo",
                    "Parte 3: Análisis Cultural\nObserva las imágenes proporcionadas de tres festivales tradicionales de diferentes países hispanohablantes y completa las siguientes tareas en español:\n\n1. Identifica cada festival y el país donde se celebra\n2. Describe los elementos culturales más importantes de cada celebración\n3. Compara y contrasta los tres festivales, destacando similitudes y diferencias\n4. Explica cómo estos festivales reflejan aspectos históricos, sociales o religiosos de sus respectivas culturas\n5. Selecciona uno de los festivales y explica por qué te gustaría participar en él",
                ],
                "evaluation_criteria" =>
                    "Tu trabajo será evaluado en función de tu comprensión de textos en español, precisión gramatical, riqueza de vocabulario, claridad de expresión, conocimiento cultural, capacidad analítica, y organización coherente de ideas. Se valorará el uso de un español natural y fluido, con atención al registro apropiado según el contexto.",
            ],
        ]);

        // Add Tasks for Foreign Language Challenge (Spanish)
        $languageChallenge = Challenge::where('name', 'Spanish Language Communication Skills')->first();
        if ($languageChallenge) {
            Task::create([
                'challenge_id' => $languageChallenge->id,
                'name' => 'Parte 1: Comprensión de Lectura',
                'description' => 'Responder a preguntas sobre un texto en español acerca de la diversidad lingüística.',
                'instructions' => "Lee el texto proporcionado en la Parte 1 y responde a las 5 preguntas en español. Asegúrate de que tus respuestas demuestren comprensión del texto. Envía tus respuestas.",
                'points_reward' => 60,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluar la comprensión del texto basada en las respuestas a las preguntas, y la corrección gramatical/vocabulario en español.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $languageChallenge->id,
                'name' => 'Parte 2: Expresión Escrita (Ensayo)',
                'description' => 'Escribir un ensayo en español sobre uno de los temas propuestos.',
                'instructions' => "Elige UNO de los temas (A, B, o C) y escribe un ensayo en español (350-450 palabras) siguiendo los requisitos: introducción con tesis, argumentos con ejemplos, conclusión, y uso correcto de gramática/vocabulario. Envía tu ensayo.",
                'points_reward' => 80,
                'submission_type' => 'text', // Or file
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluar la estructura del ensayo, claridad de la tesis, desarrollo de argumentos, corrección gramatical, riqueza de vocabulario, cohesión y coherencia en español.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $languageChallenge->id,
                'name' => 'Parte 3: Análisis Cultural (Festivales)',
                'description' => 'Analizar imágenes de festivales hispanohablantes y responder a preguntas en español.',
                'instructions' => "Observa las imágenes de festivales proporcionadas (asume que son externas). Completa las 5 tareas en español: identifica los festivales/países, describe elementos culturales, compara/contrasta, explica su reflejo cultural/histórico, y elige uno para participar explicando por qué. Envía tu análisis.",
                'points_reward' => 80,
                'submission_type' => 'text', // Could include file upload if images need referencing
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluar el conocimiento cultural sobre los festivales, la capacidad de descripción y comparación, el análisis de la significancia cultural, y la corrección/fluidez del español usado.']),
                'order' => 3,
                'is_active' => true,
            ]);
            $languageChallenge->updatePointsReward();
        }

        // ======= SOCIAL STUDIES CHALLENGES =======

        // 18. Economics Challenge
        Challenge::create([
            "name" => "Economic Analysis and Policy Evaluation",
            "description" =>
                "Apply economic theories to analyze market scenarios, evaluate policy options, and address contemporary economic challenges.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 250,
            "difficulty_level" => "advanced",
            "is_active" => true,
            "max_participants" => 35,
            "required_level" => 4,
            "challenge_type" => "problem_solving",
            "time_limit" => 150,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["economics"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your ability to apply economic theories and models to real-world scenarios, analyze market dynamics, evaluate policy alternatives, and address contemporary economic challenges. You will demonstrate your understanding of microeconomics, macroeconomics, and international economic systems.",
                "sections" => [
                    "Part 1: Microeconomic Analysis\n1. Market Structure Analysis\n   The provided data shows information about the smartphone industry, including market shares, pricing strategies, product differentiation, and barriers to entry. Using this information:\n   a) Determine the market structure (perfect competition, monopolistic competition, oligopoly, or monopoly)\n   b) Analyze how this market structure affects pricing, output, and efficiency\n   c) Calculate price elasticity of demand using the provided data and explain its implications\n   d) Evaluate the effectiveness of current antitrust policies in this industry\n\n2. Production and Cost Analysis\n   A manufacturing firm is considering expanding its operations. Using the cost and revenue data provided:\n   a) Calculate marginal cost, average total cost, and marginal revenue at different production levels\n   b) Determine the profit-maximizing level of output\n   c) Analyze how a proposed $15 minimum wage would affect the firm's costs and optimal production decisions\n   d) Recommend whether the firm should expand, maintain, or reduce production",
                    "Part 2: Macroeconomic Policy Evaluation\n1. The provided dataset shows Country X's GDP growth, inflation rate, unemployment rate, government debt, and interest rates over the past 10 years. The country is currently experiencing stagflation (high inflation and high unemployment).\n   a) Analyze the likely causes of this stagflation using economic theory\n   b) Evaluate the potential effectiveness of three different policy options:\n      - Expansionary fiscal policy\n      - Contractionary monetary policy\n      - Supply-side economic reforms\n   c) Recommend a comprehensive policy approach to address stagflation, considering potential trade-offs and long-term implications\n   d) Explain how your recommended policies would affect different sectors of the economy",
                    "Part 3: International Economics Case Study\nCountry Y is a developing nation considering different trade policies to promote economic growth. The country has abundant natural resources and low-cost labor but limited capital and technology.\n\n1. Analyze the potential benefits and costs of each policy option:\n   a) Import substitution industrialization with high tariffs on manufactured goods\n   b) Export-oriented growth strategy with trade liberalization\n   c) Strategic trade policy targeting specific industries\n\n2. Evaluate how each policy might affect:\n   a) Economic growth and development\n   b) Income distribution and poverty reduction\n   c) Environmental sustainability\n   d) Vulnerability to global economic shocks\n\n3. Recommend a trade strategy for Country Y, considering its specific economic context and development goals",
                ],
                "evaluation_criteria" =>
                    "Your work will be evaluated on economic reasoning, application of economic theories and models, quantitative analysis, policy evaluation, consideration of trade-offs and unintended consequences, use of evidence, and clarity of economic communication. All calculations should be shown, and policy recommendations should be supported with economic reasoning and evidence.",
            ],
        ]);

        // Add Tasks for Economics Challenge
        $economicsChallenge = Challenge::where('name', 'Economic Analysis and Policy Evaluation')->first();
        if ($economicsChallenge) {
             Task::create([
                'challenge_id' => $economicsChallenge->id,
                'name' => 'Part 1: Micro - Market Structure & Elasticity',
                'description' => 'Analyze the smartphone industry market structure and calculate price elasticity.',
                'instructions' => "Address Part 1, Problem 1 (a, b, c, d). Assume smartphone industry data is provided. Determine market structure, analyze its effects, calculate PED, and evaluate antitrust policies. Submit your analysis and calculations.",
                'points_reward' => 60,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate correct identification of market structure, analysis of impact, accurate PED calculation and interpretation, and reasoned evaluation of policy.']),
                'order' => 1,
                'is_active' => true,
            ]);
             Task::create([
                'challenge_id' => $economicsChallenge->id,
                'name' => 'Part 1: Micro - Production & Cost Analysis',
                'description' => "Analyze a firm's costs, determine profit-maximizing output, and assess minimum wage impact.",
                'instructions' => "Address Part 1, Problem 2 (a, b, c, d). Assume cost/revenue data is provided. Calculate MC, ATC, MR, find profit-max output (MR=MC), analyze minimum wage impact on costs/output, and recommend production level. Show calculations. Submit your analysis.",
                'points_reward' => 60,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate correct calculation of costs/revenue, identification of profit-max output, logical analysis of minimum wage impact, and justified production recommendation.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $economicsChallenge->id,
                'name' => 'Part 2: Macro - Stagflation Policy Evaluation',
                'description' => 'Analyze causes of stagflation in Country X and evaluate policy options.',
                'instructions' => "Address Part 2 (a, b, c, d). Assume Country X data is provided. Analyze causes of stagflation, evaluate fiscal, monetary, and supply-side policies, recommend a comprehensive approach, and explain sectoral effects. Submit your analysis and recommendations.",
                'points_reward' => 70,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate understanding of stagflation causes, thorough evaluation of policy options (effectiveness, trade-offs), justification for recommended policy mix, and analysis of sectoral impacts.']),
                'order' => 3,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $economicsChallenge->id,
                'name' => 'Part 3: International - Trade Policy Case Study',
                'description' => 'Analyze trade policy options for developing Country Y and recommend a strategy.',
                'instructions' => "Address Part 3 (1, 2, 3). Analyze benefits/costs of import substitution, export orientation, and strategic trade policy for Country Y. Evaluate impacts on growth, poverty, environment, and vulnerability. Recommend a justified trade strategy. Submit your analysis.",
                'points_reward' => 60,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate depth of analysis of trade policy options, assessment of multifaceted impacts, and reasoned justification for the recommended trade strategy based on Country Y context.']),
                'order' => 4,
                'is_active' => true,
            ]);
            $economicsChallenge->updatePointsReward();
        }

        // 19. Psychology Challenge
        Challenge::create([
            "name" => "Psychological Research and Analysis",
            "description" =>
                "Design psychological research, analyze behavioral patterns, and apply psychological theories to human behavior and mental processes.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(12),
            "points_reward" => 230,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 3,
            "challenge_type" => "research",
            "time_limit" => 135,
            "programming_language" => "none",
            "tech_category" => "none",
            "category_id" => $categories["psychology"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your understanding of psychological theories, research methods, and applications. You will design research studies, analyze behavioral data, and apply psychological principles to understand human behavior and mental processes.",
                "sections" => [
                    "Part 1: Research Design\nDesign a psychological research study addressing one of the following questions:\n\n1. How does social media use affect adolescent self-esteem and social comparison?\n2. What is the relationship between mindfulness meditation practice and stress reduction?\n3. How do different teaching methods affect student motivation and academic performance?\n\nYour research design should include:\na) A clearly stated research question and hypothesis\nb) Identification of independent and dependent variables\nc) Description of participant selection and characteristics\nd) Research method (experimental, correlational, observational, case study) with justification\ne) Detailed procedure including measures and materials\nf) Discussion of how you would analyze the data\ng) Consideration of ethical issues and how you would address them\nh) Identification of potential confounding variables and limitations",
                    "Part 2: Data Analysis and Interpretation\nThe dataset provided contains results from a study on the effectiveness of three different therapeutic approaches for treating anxiety disorders. It includes pre-treatment and post-treatment anxiety scores, demographic information, treatment adherence, and follow-up data.\n\n1. Analyze the provided data to determine:\n   a) Which therapeutic approach appears most effective overall\n   b) Whether effectiveness varies based on demographic factors\n   c) The relationship between treatment adherence and outcomes\n   d) Long-term effectiveness based on follow-up data\n\n2. Create appropriate visual representations of the key findings\n\n3. Write an interpretation of the results that:\n   a) Summarizes the main findings\n   b) Relates the findings to existing psychological theories\n   c) Discusses implications for clinical practice\n   d) Identifies limitations of the study and suggestions for future research",
                    "Part 3: Application of Psychological Theories\nSelect ONE of the following scenarios and analyze it from the perspective of THREE different psychological theories or approaches:\n\nScenario A: A high school student who previously performed well academically is now experiencing a significant decline in grades, withdrawal from social activities, and increased irritability.\n\nScenario B: A company is experiencing high employee turnover and declining productivity despite competitive salaries and benefits.\n\nScenario C: A community is showing resistance to adopting health precautions during a disease outbreak despite clear scientific evidence of their effectiveness.\n\nFor your chosen scenario:\n1. Analyze the situation from three different psychological perspectives (e.g., behavioral, cognitive, humanistic, psychodynamic, sociocultural, biological)\n2. Explain how each perspective would interpret the causes of the situation\n3. Describe what interventions each perspective might recommend\n4. Evaluate the strengths and limitations of each theoretical approach for this specific scenario\n5. Recommend an integrated approach that draws on multiple perspectives",
                ],
                "evaluation_criteria" =>
                    "Your work will be evaluated on understanding of psychological concepts and theories, application of research methods, ethical considerations, data analysis skills, critical thinking, integration of multiple perspectives, evidence-based reasoning, and clarity of communication. Responses should demonstrate both breadth and depth of psychological knowledge.",
            ],
        ]);

        // Add Tasks for Psychology Challenge
        $psychologyChallenge = Challenge::where('name', 'Psychological Research and Analysis')->first();
        if ($psychologyChallenge) {
            Task::create([
                'challenge_id' => $psychologyChallenge->id,
                'name' => 'Part 1: Research Design Proposal',
                'description' => 'Design a psychological research study for one of the given questions.',
                'instructions' => "Choose ONE research question. Design a study including: question/hypothesis, variables, participants, method (justified), procedure, data analysis plan, ethical considerations/solutions, and limitations/confounds. Submit your detailed research design.",
                'points_reward' => 80,
                'submission_type' => 'text', // Or file
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate clarity of research question/hypothesis, appropriateness of method, detail in procedure, soundness of analysis plan, thoroughness of ethical considerations, and identification of limitations.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $psychologyChallenge->id,
                'name' => 'Part 2: Data Analysis and Interpretation',
                'description' => 'Analyze provided therapy effectiveness data, create visualizations, and interpret results.',
                'instructions' => "Assume therapy dataset is provided. Analyze it to answer questions (a-d) regarding effectiveness, demographics, adherence, and long-term outcomes. Create visual representations (e.g., graphs). Write an interpretation summarizing findings, relating to theory, discussing implications, and limitations. Submit analysis, visualizations (file upload/link), and interpretation.",
                'points_reward' => 80,
                'submission_type' => 'file', // For visualizations + text analysis
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate accuracy of data analysis, appropriateness/clarity of visualizations, depth of interpretation, connection to theory, clinical implications, and identification of limitations.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $psychologyChallenge->id,
                'name' => 'Part 3: Application of Theories (Scenario Analysis)',
                'description' => 'Analyze one of the scenarios using three different psychological perspectives.',
                'instructions' => "Choose ONE scenario (A, B, or C). Analyze it from THREE different psychological perspectives. Explain how each interprets causes, recommend interventions from each, evaluate strengths/limitations of each approach for the scenario, and suggest an integrated approach. Submit your multi-perspective analysis.",
                'points_reward' => 70,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate understanding and application of three distinct psychological perspectives, quality of analysis of causes/interventions, critical evaluation of approaches, and coherence of the integrated approach.']),
                'order' => 3,
                'is_active' => true,
            ]);
            $psychologyChallenge->updatePointsReward();
        }

        // ======= TECHNOLOGICAL LITERACY CHALLENGES =======

        // 20. Digital Media Production Challenge
        Challenge::create([
            "name" => "Digital Storytelling and Multimedia Production",
            "description" =>
                "Create a compelling digital story combining various multimedia elements to communicate a narrative on a contemporary issue.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(16),
            "points_reward" => 270,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 35,
            "required_level" => 3,
            "challenge_type" => "creative",
            "time_limit" => 180,
            "programming_language" => "none",
            "tech_category" => "digital_media",
            "category_id" => $categories["technology"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "This challenge tests your ability to create an effective digital narrative using multiple media formats. You will plan, produce, and present a compelling digital story that communicates a meaningful message about a contemporary issue.",
                "sections" => [
                    "Project Brief:\nCreate a digital storytelling project that explores ONE of the following themes:\n1. Digital Citizenship and Online Ethics\n2. Environmental Sustainability in Your Community\n3. Cultural Heritage and Identity in the Digital Age\n4. Technology's Impact on Human Connection\n5. Public Health Awareness\n\nYour digital story should:\n- Target a specific audience with a clear purpose (inform, persuade, or inspire action)\n- Integrate at least three different media formats (video, audio, images, animation, infographics, interactive elements)\n- Present a coherent narrative with a beginning, middle, and end\n- Include both factual information and human/emotional elements\n- Demonstrate thoughtful application of design principles and communication techniques",
                    "Required Components:\n1. Planning Documentation:\n   - Project concept statement (100-150 words)\n   - Storyboard or outline showing narrative structure\n   - Script or narration text\n   - Target audience analysis and communication goals\n\n2. Digital Story Production:\n   - 3-5 minute digital story combining multiple media elements\n   - Original content created by you (may incorporate properly attributed external content where appropriate)\n   - Proper technical execution (audio quality, visual clarity, timing, transitions)\n   - Thoughtful use of design elements (color, typography, composition, pacing)\n\n3. Reflection and Analysis:\n   - Brief written analysis (300-400 words) explaining your creative choices\n   - Discussion of how your media choices support your narrative goals\n   - Reflection on challenges encountered and how you addressed them\n   - Description of how you applied principles from digital media theory",
                    "Technical Requirements:\n1. File Formats:\n   - Final project should be submitted as a video file (.mp4, .mov) or interactive HTML package\n   - Planning documents in PDF format\n   - Original source files (images, audio, etc.) in appropriate formats\n\n2. Production Tools:\n   - You may use any combination of digital media tools and software\n   - All tools and resources used must be properly documented\n   - If using third-party assets, they must be properly licensed and attributed",
                ],
                "evaluation_criteria" =>
                    "Your project will be evaluated on narrative effectiveness, creative concept, technical execution, integration of multiple media formats, audience awareness, information quality and accuracy, aesthetic design, originality, ethical use of content, documentation quality, and reflection depth. Both the final product and the process documentation will be considered in assessment.",
            ],
        ]);

        // Add Tasks for Digital Media Production Challenge
        $digitalMediaChallenge = Challenge::where('name', 'Digital Storytelling and Multimedia Production')->first();
        if ($digitalMediaChallenge) {
            Task::create([
                'challenge_id' => $digitalMediaChallenge->id,
                'name' => 'Project Planning Documentation',
                'description' => 'Submit the planning documents for your digital storytelling project.',
                'instructions' => "Choose ONE theme. Submit the required planning documents: concept statement, storyboard/outline, script/narration text, and target audience analysis/goals. Submit as a single PDF.",
                'points_reward' => 70,
                'submission_type' => 'file',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate clarity of concept, completeness and coherence of storyboard/outline, quality of script, and thoughtfulness of audience analysis.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $digitalMediaChallenge->id,
                'name' => 'Digital Story Production',
                'description' => 'Submit the final 3-5 minute digital story.',
                'instructions' => "Produce the final digital story based on your plan, integrating at least three media types. Ensure good technical quality and design. Submit the video file (.mp4, .mov) or interactive HTML package.",
                'points_reward' => 130,
                'submission_type' => 'file', // Or URL if hosted
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate narrative effectiveness, creativity, technical execution (audio/visual quality, editing), integration of media, design, originality, and adherence to brief.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $digitalMediaChallenge->id,
                'name' => 'Reflection and Analysis',
                'description' => 'Submit a written reflection and analysis of your digital storytelling project.',
                'instructions' => "Write a reflection (300-400 words) explaining your creative choices, how media supported the narrative, challenges faced, and application of digital media principles. Submit your written reflection.",
                'points_reward' => 70,
                'submission_type' => 'text',
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate depth of reflection on creative choices, process challenges, and connection to digital media theory/principles.']),
                'order' => 3,
                'is_active' => true,
            ]);
            $digitalMediaChallenge->updatePointsReward();
        }

        // 21. Data Visualization Challenge
        Challenge::create([
            "name" => "Public Health Data Visualization",
            "description" =>
                "Create effective data visualizations to communicate complex public health information to different audiences.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 240,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 3,
            "challenge_type" => "data_visualization",
            "time_limit" => 150,
            "programming_language" => "any",
            "tech_category" => "data_science",
            "category_id" => $categories["technology"] ?? null,
            "challenge_content" => [
                "problem_statement" =>
                    "As a data analyst for a public health department, you've been tasked with creating effective visualizations of COVID-19 vaccination data to communicate important trends and insights to different audiences. You will work with vaccination rate data across different demographics and regions to create visualizations that inform policy decisions and public understanding.",
                "sections" => [
                    "Part 1: Data Exploration and Preparation\nYou are provided with the following dataset: \"covid_vaccination_data.csv\" containing information about vaccination rates by region, age group, socioeconomic status, and time period.\n\n1. Explore the dataset to understand its structure and content\n2. Clean the data as necessary (handling missing values, outliers, etc.)\n3. Perform preliminary analysis to identify key patterns and relationships\n4. Prepare the data for visualization, including any necessary transformations or calculations\n5. Document your data preparation process and initial findings",
                    "Part 2: Creating Visualizations for Different Audiences\nCreate three different visualizations designed for the following specific audiences:\n\n1. Technical Audience (Public Health Officials and Epidemiologists):\n   - Create a detailed visualization that shows the relationship between vaccination rates, demographic factors, and disease outcomes\n   - Include appropriate statistical measures and technical details\n   - Focus on accuracy, completeness, and analytical insights\n\n2. Policy Makers (Government Officials):\n   - Create a visualization that highlights geographical and demographic disparities in vaccination rates\n   - Emphasize trends that require policy intervention\n   - Balance detail with clarity to support decision-making\n   - Include actionable insights and potential policy implications\n\n3. General Public:\n   - Create an accessible, easy-to-understand visualization about vaccination progress\n   - Focus on key messages that are relevant to individual decision-making\n   - Ensure the visualization is intuitive and requires minimal specialized knowledge\n   - Address common concerns or misconceptions evident in the data",
                    "Part 3: Interactive Dashboard\nDesign a mockup or prototype of an interactive dashboard that integrates multiple visualizations from the dataset. The dashboard should:\n\n1. Allow users to filter and explore the data across different dimensions\n2. Include at least three complementary visualization types that show different aspects of the data\n3. Provide clear context and explanations for interpreting the visualizations\n4. Follow best practices for dashboard design (layout, color scheme, accessibility)\n5. Include a brief user guide explaining how to use the dashboard",
                ],
                "evaluation_criteria" =>
                    "Your visualizations will be evaluated on data accuracy, appropriate visualization types for the information and audience, effective use of visual elements (color, shape, size, labels), clarity of communication, technical execution, accessibility, context provided, creativity in presenting complex information, and overall effectiveness in conveying insights. Documentation of your process and design choices will also be considered.",
            ],
        ]);

        // Add Tasks for Data Visualization Challenge
        $dataVisChallenge = Challenge::where('name', 'Public Health Data Visualization')->first();
        if ($dataVisChallenge) {
             Task::create([
                'challenge_id' => $dataVisChallenge->id,
                'name' => 'Part 1: Data Exploration and Preparation',
                'description' => 'Explore, clean, analyze, and prepare the provided COVID-19 vaccination dataset.',
                'instructions' => "Assume 'covid_vaccination_data.csv' is provided. Perform steps 1-5: explore, clean, preliminary analysis, prepare data for visualization, and document the process/findings. Submit your documented process and findings (e.g., Jupyter notebook, R Markdown, or text document with code snippets).",
                'points_reward' => 60,
                'submission_type' => 'file', // Or text with code
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate thoroughness of exploration, appropriateness of cleaning steps, quality of preliminary analysis, data preparation logic, and clarity of documentation.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $dataVisChallenge->id,
                'name' => 'Part 2: Visualizations for Different Audiences',
                'description' => 'Create three distinct visualizations tailored for technical, policy, and public audiences.',
                'instructions' => "Create the three visualizations specified in Part 2 for the different audiences, using the prepared data. Focus on tailoring the complexity, message, and design for each audience. Submit the visualizations (e.g., image files, links to interactive plots) along with brief justifications for your design choices for each.",
                'points_reward' => 90, // 30 points each
                'submission_type' => 'file', // Or URL
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate appropriateness of visualization type, clarity, design effectiveness, and tailoring for each specified audience (technical, policy, public). Check justification.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $dataVisChallenge->id,
                'name' => 'Part 3: Interactive Dashboard Mockup/Prototype',
                'description' => 'Design a mockup or prototype of an interactive dashboard integrating multiple visualizations.',
                'instructions' => "Design a mockup/prototype (e.g., using Figma, Balsamiq, or even a well-described document with sketches) of the interactive dashboard described in Part 3. Include layout, visualization types, filtering ideas, context, and a user guide. Submit the mockup/prototype file or link, and the user guide.",
                'points_reward' => 90,
                'submission_type' => 'file', // Or URL
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate dashboard design principles (layout, clarity), choice of visualizations, interactivity features, context provided, usability, and quality of user guide.']),
                'order' => 3,
                'is_active' => true,
            ]);
            $dataVisChallenge->updatePointsReward();
        }

        // Existing Database Challenge (Hospital Management)
        $databaseHospitalChallenge = Challenge::where('name', 'Database Challenge - Hospital Management System')->first();
        if ($databaseHospitalChallenge) {
             // Extract tasks from challenge_content and create Task models
            Task::create([
                'challenge_id' => $databaseHospitalChallenge->id,
                'name' => 'Design Medical Records, Prescriptions, Billing, Insurance, Inventory Tables',
                'description' => 'Extend the provided schema to include tables for medical records, prescriptions, billing, insurance, and inventory, establishing appropriate relationships.',
                'instructions' => 'Provide the SQL `CREATE TABLE` statements for the required additional tables (MedicalRecords, Prescriptions, Billing, Insurance, InventoryItems, etc.). Ensure foreign keys are correctly defined to link tables (e.g., Prescriptions to Patients and Staff, Billing to Patients and Appointments).',
                'points_reward' => 80,
                'submission_type' => 'text', // SQL Code
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check for completeness of required tables, appropriate column types, primary/foreign key definitions, and logical relationships between tables.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $databaseHospitalChallenge->id,
                'name' => 'Implement Indexes and Constraints',
                'description' => 'Create appropriate indexes for performance and implement data integrity constraints.',
                'instructions' => 'Add necessary indexes (e.g., on foreign keys, frequently queried columns like patient names, appointment dates). Implement constraints (e.g., CHECK constraints for dosages, UNIQUE constraints where needed, NOT NULL constraints). Provide the SQL `CREATE INDEX` and `ALTER TABLE ... ADD CONSTRAINT` statements.',
                'points_reward' => 70,
                'submission_type' => 'text', // SQL Code
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check for logical index creation on relevant columns and implementation of meaningful constraints to ensure data integrity.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $databaseHospitalChallenge->id,
                'name' => 'Create Stored Procedures',
                'description' => 'Implement stored procedures for common operations like appointment scheduling and prescription management.',
                'instructions' => 'Write SQL stored procedures for: 1) Scheduling a new appointment (checking for conflicts). 2) Adding a new prescription for a patient. Ensure procedures handle inputs and perform necessary insertions/updates.',
                'points_reward' => 80,
                'submission_type' => 'text', // SQL Code
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check procedures for correct SQL logic, parameter handling, error checking (optional but good), and successful execution of intended database operations.']),
                'order' => 3,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $databaseHospitalChallenge->id,
                'name' => 'Create Views for Stakeholders',
                'description' => 'Implement SQL views for different user roles (Doctor, Nurse, Billing).',
                'instructions' => 'Create SQL views: 1) `DoctorPatientView` showing doctor\'s upcoming appointments and associated patient details. 2) `NurseShiftView` showing patients assigned to a nurse for a specific shift/ward (requires adding shift/ward info or making assumptions). 3) `BillingSummaryView` showing patient appointment costs and insurance status. Provide the `CREATE VIEW` statements.',
                'points_reward' => 60,
                'submission_type' => 'text', // SQL Code
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Check views for correct joining of tables and selection of relevant columns appropriate for each stakeholder role.']),
                'order' => 4,
                'is_active' => true,
            ]);
            // Note: Task 6 (Data access layer) is more about application code, harder to represent as a pure SQL task. Could be a conceptual task.
             Task::create([
                'challenge_id' => $databaseHospitalChallenge->id,
                'name' => 'Data Access Security Concept',
                'description' => 'Describe how you would implement security controls for HIPAA compliance in the data access layer.',
                'instructions' => 'Explain the strategies and techniques you would use in an application layer (e.g., using an ORM, backend framework) to enforce access controls based on user roles (Doctor, Nurse, Admin, Patient) to comply with HIPAA principles like minimum necessary access. Focus on the concepts, not specific code.',
                'points_reward' => 60,
                'submission_type' => 'text', // Explanation
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate the understanding of role-based access control, principles of least privilege, and HIPAA considerations applied to database access patterns from an application perspective.']),
                'order' => 5,
                'is_active' => true,
            ]);
            $databaseHospitalChallenge->updatePointsReward();
        }

        // Existing UI/UX Challenge (Financial Dashboard)
        $uiUxChallenge = Challenge::where('name', 'UI/UX Challenge - Financial Dashboard Design')->first();
         if ($uiUxChallenge) {
            // Extract tasks from challenge_content and create Task models
            Task::create([
                'challenge_id' => $uiUxChallenge->id,
                'name' => 'Dashboard Wireframes (Main + 2 Secondary)',
                'description' => 'Create wireframes for the main dashboard view and two detailed secondary screens (e.g., Asset Details, Transaction History).',
                'instructions' => 'Submit wireframes showing layout, content areas, key UI elements, and navigation flow for the main dashboard and two other important screens. Focus on structure and information hierarchy. Submit as image files or link to prototyping tool (e.g., Figma, Balsamiq).',
                'points_reward' => 70,
                'submission_type' => 'file', // Or URL
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate clarity, information architecture, logical flow, and completeness of wireframes for the required screens.']),
                'order' => 1,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $uiUxChallenge->id,
                'name' => 'High-Fidelity Mockups (Light & Dark Mode)',
                'description' => 'Design high-fidelity mockups for the main dashboard screen, including data visualizations, in both light and dark modes.',
                'instructions' => 'Create visually detailed mockups for the main dashboard screen, incorporating color scheme, typography, data visualization components (charts/graphs), and navigation. Provide both light and dark mode versions. Submit as image files or link.',
                'points_reward' => 80,
                'submission_type' => 'file', // Or URL
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate visual appeal, consistency, usability, clarity of data visualization, and successful implementation of both light and dark modes.']),
                'order' => 2,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $uiUxChallenge->id,
                'name' => 'Responsive Design Mockups (Tablet & Mobile)',
                'description' => 'Create mockups showing the responsive design of the main dashboard for tablet and mobile views.',
                'instructions' => 'Design how the main dashboard layout and components adapt to typical tablet and mobile screen sizes. Focus on maintaining usability and accessibility of key information. Submit as image files or link.',
                'points_reward' => 70,
                'submission_type' => 'file', // Or URL
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate effective adaptation of layout, navigation, and content for smaller screens, ensuring usability and accessibility.']),
                'order' => 3,
                'is_active' => true,
            ]);
            Task::create([
                'challenge_id' => $uiUxChallenge->id,
                'name' => 'UI Style Guide',
                'description' => 'Create a style guide documenting UI components, colors, typography, and usage guidelines.',
                'instructions' => 'Develop a style guide that documents the key visual elements of your design: color palette, typography (fonts, sizes, weights), iconography, button styles, form elements, spacing rules, etc. Submit as a PDF or link.',
                'points_reward' => 80,
                'submission_type' => 'file', // Or URL
                'evaluation_type' => 'manual',
                'evaluation_details' => json_encode(['guidelines' => 'Evaluate completeness, clarity, consistency, and usefulness of the style guide for developers implementing the design.']),
                'order' => 4,
                'is_active' => true,
            ]);
            $uiUxChallenge->updatePointsReward();
        }
    }

    /**
     * Create necessary categories if they don't exist
     */
    private function createCategoriesIfNeeded(): void
    {
        $categories = [
            [
                "name" => "Computer Science",
                "slug" => "computer-science",
                "description" =>
                    "Programming, algorithms, databases, cybersecurity, and computer systems",
            ],
            [
                "name" => "Mathematics",
                "slug" => "mathematics",
                "description" =>
                    "Algebra, calculus, statistics, geometry, and mathematical problem solving",
            ],
            [
                "name" => "Physics",
                "slug" => "physics",
                "description" =>
                    "Mechanics, electricity, magnetism, thermodynamics, and modern physics",
            ],
            [
                "name" => "Chemistry",
                "slug" => "chemistry",
                "description" =>
                    "Chemical reactions, organic chemistry, inorganic chemistry, and biochemistry",
            ],
            [
                "name" => "Biology",
                "slug" => "biology",
                "description" =>
                    "Cellular biology, genetics, ecology, evolution, and human physiology",
            ],
            [
                "name" => "History",
                "slug" => "history",
                "description" =>
                    "World history, historical analysis, and primary source examination",
            ],
            [
                "name" => "Literature",
                "slug" => "literature",
                "description" =>
                    "Literary analysis, comparative literature, and creative writing",
            ],
            [
                "name" => "Economics",
                "slug" => "economics",
                "description" =>
                    "Microeconomics, macroeconomics, economic policy, and financial analysis",
            ],
            [
                "name" => "Geography",
                "slug" => "geography",
                "description" =>
                    "Physical geography, human geography, and geospatial analysis",
            ],
            [
                "name" => "Psychology",
                "slug" => "psychology",
                "description" =>
                    "Human behavior, cognitive psychology, and research methods",
            ],
            [
                "name" => "English",
                "slug" => "english",
                "description" =>
                    "Writing, rhetoric, composition, and communication skills",
            ],
            [
                "name" => "Languages",
                "slug" => "languages",
                "description" =>
                    "Foreign language acquisition and cultural studies",
            ],
            [
                "name" => "Technology",
                "slug" => "technology",
                "description" =>
                    "Digital literacy, media production, and technological applications",
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ["slug" => $category["slug"]],
                [
                    "name" => $category["name"],
                    "description" => $category["description"],
                ]
            );
        }
    }
}
