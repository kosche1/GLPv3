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

        // Continue with existing challenges from the original seeder
        Challenge::create([
            "name" => "Database Challenge - Hospital Management System",
            "description" =>
                "Design and implement a comprehensive database for a modern hospital management system that handles patients, staff, appointments, and medical records.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(21),
            "points_reward" => 350,
            "difficulty_level" => "advanced",
            "is_active" => true,
            "max_participants" => 25,
            "required_level" => 5,
            "challenge_type" => "database",
            "time_limit" => 240,
            "programming_language" => "sql",
            "tech_category" => "healthcare_it",
            "category_id" => $categories["computer-science"] ?? null,
            "challenge_content" => [
                "scenario" =>
                    "A large hospital is modernizing its IT infrastructure and needs a robust database design for its new Hospital Management System. The system must track patients, doctors, nurses, appointments, medical records, prescriptions, billing, insurance claims, and inventory while ensuring data integrity, security, and compliance with healthcare regulations.",
                "schema" =>
                    "-- Existing partial schema (needs to be extended):\n\nCREATE TABLE patients (\n  patient_id INT PRIMARY KEY,\n  first_name VARCHAR(50),\n  last_name VARCHAR(50),\n  date_of_birth DATE,\n  gender VARCHAR(10),\n  contact_number VARCHAR(15),\n  email VARCHAR(100),\n  address TEXT,\n  emergency_contact VARCHAR(100),\n  blood_type VARCHAR(5),\n  registration_date DATE\n);\n\nCREATE TABLE staff (\n  staff_id INT PRIMARY KEY,\n  first_name VARCHAR(50),\n  last_name VARCHAR(50),\n  role VARCHAR(50),\n  department VARCHAR(50),\n  contact_number VARCHAR(15),\n  email VARCHAR(100),\n  hire_date DATE\n);\n\nCREATE TABLE appointments (\n  appointment_id INT PRIMARY KEY,\n  patient_id INT,\n  staff_id INT,\n  appointment_date DATETIME,\n  purpose VARCHAR(200),\n  status VARCHAR(20),\n  FOREIGN KEY (patient_id) REFERENCES patients(patient_id),\n  FOREIGN KEY (staff_id) REFERENCES staff(staff_id)\n);",
                "tasks" =>
                    "1. Design additional tables for medical records, prescriptions, billing, insurance, and inventory with appropriate relationships.\n2. Create appropriate indexes to optimize query performance.\n3. Implement constraints to ensure data integrity (e.g., valid medication dosages, appointment scheduling rules).\n4. Design and implement stored procedures for common operations (appointment scheduling, prescription management).\n5. Implement views for different stakeholders (doctor view, nurse view, billing department view).\n6. Create a data access layer with proper security controls for HIPAA compliance.",
                "sample_data" =>
                    "-- Sample patient data\nINSERT INTO patients VALUES (1001, 'John', 'Smith', '1975-05-15', 'Male', '555-123-4567', 'john.smith@email.com', '123 Main St, Anytown, USA', 'Mary Smith: 555-987-6543', 'O+', '2022-01-10');\nINSERT INTO patients VALUES (1002, 'Jane', 'Doe', '1988-09-23', 'Female', '555-234-5678', 'jane.doe@email.com', '456 Oak Ave, Somewhere, USA', 'Robert Doe: 555-876-5432', 'AB-', '2022-02-15');\n\n-- Sample staff data\nINSERT INTO staff VALUES (101, 'David', 'Miller', 'Doctor', 'Cardiology', '555-111-2222', 'david.miller@hospital.org', '2020-03-15');\nINSERT INTO staff VALUES (102, 'Sarah', 'Johnson', 'Nurse', 'Emergency', '555-333-4444', 'sarah.johnson@hospital.org', '2021-06-10');\nINSERT INTO staff VALUES (103, 'Michael', 'Brown', 'Doctor', 'Neurology', '555-555-6666', 'michael.brown@hospital.org', '2019-11-05');\n\n-- Sample appointment data\nINSERT INTO appointments VALUES (5001, 1001, 101, '2023-03-15 10:30:00', 'Routine checkup', 'Completed');\nINSERT INTO appointments VALUES (5002, 1002, 103, '2023-03-16 14:45:00', 'Migraine consultation', 'Scheduled');\nINSERT INTO appointments VALUES (5003, 1001, 101, '2023-04-20 11:15:00', 'Follow-up', 'Scheduled');",
            ],
        ]);

        Challenge::create([
            "name" => "UI/UX Challenge - Financial Dashboard Design",
            "description" =>
                "Design an intuitive and visually appealing financial analytics dashboard for investment portfolio tracking and analysis.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 0,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 3,
            "challenge_type" => "ui_design",
            "time_limit" => 150,
            "programming_language" => "none",
            "tech_category" => "fintech",
            "category_id" => $categories["computer-science"] ?? null,
            "challenge_content" => [
                "design_brief" =>
                    "A leading investment firm is developing a new web-based platform for their clients to track and analyze their investment portfolios. They need a modern, intuitive dashboard that displays complex financial data in an accessible way. The dashboard should cater to both casual investors and financial professionals, with appropriate data visualization, filtering options, and customization features.\n\nThe dashboard must include portfolio overview, asset allocation, performance metrics, market trends, transaction history, and alert notifications. It should also offer responsive design for mobile and tablet access.",
                "requirements" =>
                    "1. Create wireframes for the main dashboard view and at least 2 detailed secondary screens.\n2. Design high-fidelity mockups with a consistent color scheme and typography.\n3. Include data visualization components (charts, graphs) for financial metrics.\n4. Design intuitive navigation and filtering mechanisms.\n5. Include both light and dark mode versions.\n6. Implement responsive layouts for desktop, tablet, and mobile views.\n7. Consider accessibility requirements for color contrast and readability.\n8. Create a style guide documenting UI components, colors, typography, and usage guidelines.",
                "evaluation_criteria" =>
                    "Designs will be judged on visual appeal, usability, information architecture, accessibility, originality, and technical feasibility. Special attention will be given to how complex financial data is represented in a user-friendly manner, and how the design accommodates both novice and expert users.",
            ],
        ]);
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
