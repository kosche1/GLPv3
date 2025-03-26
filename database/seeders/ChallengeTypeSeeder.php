<?php

namespace Database\Seeders;

use App\Models\Challenge;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChallengeTypeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Debugging Challenge - Security Vulnerability Assessment
        Challenge::create([
            "name" => "Web Security Vulnerability Assessment",
            "description" => "Identify and fix common security vulnerabilities in a web application including XSS, CSRF, and SQL injection vulnerabilities.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(10),
            "points_reward" => 250,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 50,
            "required_level" => 4,
            "challenge_type" => "debugging",
            "time_limit" => 120, // 2 hours
            "programming_language" => "php",
            "tech_category" => "security",
            "challenge_content" => [
                "scenario" => "You're a security consultant hired to assess a client's e-commerce application for vulnerabilities before its launch. You've been provided with code snippets that need to be reviewed and fixed.",
                "buggy_code" => "<?php\n// User search function with SQL injection vulnerability\nfunction searchUsers(\$query) {\n    global \$db;\n    \$sql = \"SELECT * FROM users WHERE username LIKE '%\" . \$query . \"%'\";\n    return \$db->query(\$sql);\n}\n\n// Login form with CSRF vulnerability\nfunction renderLoginForm() {\n    echo '<form method=\"POST\" action=\"/login.php\">';\n    echo '<input type=\"text\" name=\"username\" placeholder=\"Username\">';\n    echo '<input type=\"password\" name=\"password\" placeholder=\"Password\">';\n    echo '<button type=\"submit\">Login</button>';\n    echo '</form>';\n}\n\n// Output user data with XSS vulnerability\nfunction displayUserProfile(\$userData) {\n    echo '<h2>Welcome back, ' . \$userData['name'] . '</h2>';\n    echo '<div>Bio: ' . \$userData['bio'] . '</div>';\n    echo '<div>Website: ' . \$userData['website'] . '</div>';\n}\n\n// Password reset with insecure practices\nfunction resetPassword(\$email) {\n    global \$db;\n    \$newPassword = 'reset' . rand(1000, 9999);\n    \$query = \"UPDATE users SET password = '\" . \$newPassword . \"' WHERE email = '\" . \$email . \"'\";\n    \$db->query(\$query);\n    mail(\$email, 'Password Reset', \"Your new password is: \" . \$newPassword);\n    return true;\n}",
                "expected_behavior" => "1. The searchUsers function should use parameterized queries to prevent SQL injection.\n2. The login form should include CSRF protection tokens.\n3. The displayUserProfile function should sanitize user data to prevent XSS attacks.\n4. The resetPassword function should use secure password hashing and not email plaintext passwords.",
                "current_behavior" => "1. The searchUsers function is vulnerable to SQL injection attacks.\n2. The login form lacks CSRF protection.\n3. The displayUserProfile function renders unsanitized user input, making it vulnerable to XSS.\n4. The resetPassword function uses plaintext passwords and insecure SQL queries.",
            ],
        ]);

        // 2. Algorithm Challenge - E-commerce Recommendation Engine
        Challenge::create([
            "name" => "Product Recommendation Algorithm",
            "description" => "Design and implement a recommendation algorithm for an e-commerce website based on user purchase history and browsing patterns.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 300,
            "difficulty_level" => "advanced",
            "is_active" => true,
            "max_participants" => 30,
            "required_level" => 6,
            "challenge_type" => "algorithm",
            "time_limit" => 180, // 3 hours
            "programming_language" => "python",
            "tech_category" => "data_science",
            "challenge_content" => [
                "problem_statement" => "An e-commerce company wants to improve its product recommendation system. Your task is to design and implement an algorithm that analyzes customer purchase history, browsing patterns, and product similarity to generate personalized product recommendations.\n\nYou are provided with three datasets: 1) user_purchase_history.csv - containing user IDs and their past purchases, 2) product_catalog.csv - containing product details including categories and attributes, and 3) user_browsing_data.csv - containing records of user browsing sessions.\n\nYour algorithm should generate a list of top 5 product recommendations for each user that maximizes the likelihood of purchase based on their behavior patterns and product relationships.",
                "algorithm_type" => "other",
                "example" => "Input:\nUser ID: 12345\nPurchase History: [ProductID: 101 (Wireless Headphones), ProductID: 203 (Smartphone Case), ProductID: 150 (Bluetooth Speaker)]\nBrowsing History: [ProductID: 205 (Phone Charger), ProductID: 180 (Smartwatch), ProductID: 110 (Wireless Earbuds)]\n\nExpected Output:\nRecommended Products for User 12345:\n1. ProductID: 190 (Power Bank) - Based on category similarity and complementary products\n2. ProductID: 112 (Noise Cancelling Headphones) - Based on product similarity\n3. ProductID: 185 (Fitness Tracker) - Based on browsing pattern\n4. ProductID: 210 (Screen Protector) - Based on complementary purchase\n5. ProductID: 155 (Portable Speaker) - Based on product category interest",
                "solution_approach" => "Your approach should consider implementing a hybrid recommendation system that combines collaborative filtering (analyzing purchase patterns of similar users) and content-based filtering (recommending items with similar attributes to ones the user has shown interest in). Consider using techniques such as cosine similarity for product relatedness, weighted scoring for recency of interactions, and potentially matrix factorization for uncovering latent features in user-product interactions. Your solution will be evaluated on recommendation relevance, algorithm efficiency, and implementation quality.",
            ],
        ]);

        // 3. Database Challenge - Hospital Management System
        Challenge::create([
            "name" => "Healthcare Database Design Challenge",
            "description" => "Design and implement a comprehensive database for a modern hospital management system that handles patients, staff, appointments, and medical records.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(21),
            "points_reward" => 350,
            "difficulty_level" => "advanced",
            "is_active" => true,
            "max_participants" => 25,
            "required_level" => 5,
            "challenge_type" => "database",
            "time_limit" => 240, // 4 hours
            "programming_language" => "sql",
            "tech_category" => "healthcare_it",
            "challenge_content" => [
                "scenario" => "A large hospital is modernizing its IT infrastructure and needs a robust database design for its new Hospital Management System. The system must track patients, doctors, nurses, appointments, medical records, prescriptions, billing, insurance claims, and inventory while ensuring data integrity, security, and compliance with healthcare regulations.",
                "schema" => "-- Existing partial schema (needs to be extended):\n\nCREATE TABLE patients (\n  patient_id INT PRIMARY KEY,\n  first_name VARCHAR(50),\n  last_name VARCHAR(50),\n  date_of_birth DATE,\n  gender VARCHAR(10),\n  contact_number VARCHAR(15),\n  email VARCHAR(100),\n  address TEXT,\n  emergency_contact VARCHAR(100),\n  blood_type VARCHAR(5),\n  registration_date DATE\n);\n\nCREATE TABLE staff (\n  staff_id INT PRIMARY KEY,\n  first_name VARCHAR(50),\n  last_name VARCHAR(50),\n  role VARCHAR(50),\n  department VARCHAR(50),\n  contact_number VARCHAR(15),\n  email VARCHAR(100),\n  hire_date DATE\n);\n\nCREATE TABLE appointments (\n  appointment_id INT PRIMARY KEY,\n  patient_id INT,\n  staff_id INT,\n  appointment_date DATETIME,\n  purpose VARCHAR(200),\n  status VARCHAR(20),\n  FOREIGN KEY (patient_id) REFERENCES patients(patient_id),\n  FOREIGN KEY (staff_id) REFERENCES staff(staff_id)\n);",
                "tasks" => "1. Design additional tables for medical records, prescriptions, billing, insurance, and inventory with appropriate relationships.\n2. Create appropriate indexes to optimize query performance.\n3. Implement constraints to ensure data integrity (e.g., valid medication dosages, appointment scheduling rules).\n4. Design and implement stored procedures for common operations (appointment scheduling, prescription management).\n5. Implement views for different stakeholders (doctor view, nurse view, billing department view).\n6. Create a data access layer with proper security controls for HIPAA compliance.",
                "sample_data" => "-- Sample patient data\nINSERT INTO patients VALUES (1001, 'John', 'Smith', '1975-05-15', 'Male', '555-123-4567', 'john.smith@email.com', '123 Main St, Anytown, USA', 'Mary Smith: 555-987-6543', 'O+', '2022-01-10');\nINSERT INTO patients VALUES (1002, 'Jane', 'Doe', '1988-09-23', 'Female', '555-234-5678', 'jane.doe@email.com', '456 Oak Ave, Somewhere, USA', 'Robert Doe: 555-876-5432', 'AB-', '2022-02-15');\n\n-- Sample staff data\nINSERT INTO staff VALUES (101, 'David', 'Miller', 'Doctor', 'Cardiology', '555-111-2222', 'david.miller@hospital.org', '2020-03-15');\nINSERT INTO staff VALUES (102, 'Sarah', 'Johnson', 'Nurse', 'Emergency', '555-333-4444', 'sarah.johnson@hospital.org', '2021-06-10');\nINSERT INTO staff VALUES (103, 'Michael', 'Brown', 'Doctor', 'Neurology', '555-555-6666', 'michael.brown@hospital.org', '2019-11-05');\n\n-- Sample appointment data\nINSERT INTO appointments VALUES (5001, 1001, 101, '2023-03-15 10:30:00', 'Routine checkup', 'Completed');\nINSERT INTO appointments VALUES (5002, 1002, 103, '2023-03-16 14:45:00', 'Migraine consultation', 'Scheduled');\nINSERT INTO appointments VALUES (5003, 1001, 101, '2023-04-20 11:15:00', 'Follow-up', 'Scheduled');",
            ],
        ]);

        // 4. UI/UX Challenge - Financial Dashboard Design
        Challenge::create([
            "name" => "Financial Analytics Dashboard UI/UX Challenge",
            "description" => "Design an intuitive and visually appealing financial analytics dashboard for investment portfolio tracking and analysis.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 275,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 40,
            "required_level" => 3,
            "challenge_type" => "ui_design",
            "time_limit" => 150, // 2.5 hours
            "programming_language" => "none",
            "tech_category" => "fintech",
            "challenge_content" => [
                "design_brief" => "A leading investment firm is developing a new web-based platform for their clients to track and analyze their investment portfolios. They need a modern, intuitive dashboard that displays complex financial data in an accessible way. The dashboard should cater to both casual investors and financial professionals, with appropriate data visualization, filtering options, and customization features.\n\nThe dashboard must include portfolio overview, asset allocation, performance metrics, market trends, transaction history, and alert notifications. It should also offer responsive design for mobile and tablet access.",
                "requirements" => "1. Create wireframes for the main dashboard view and at least 2 detailed secondary screens.\n2. Design high-fidelity mockups with a consistent color scheme and typography.\n3. Include data visualization components (charts, graphs) for financial metrics.\n4. Design intuitive navigation and filtering mechanisms.\n5. Include both light and dark mode versions.\n6. Implement responsive layouts for desktop, tablet, and mobile views.\n7. Consider accessibility requirements for color contrast and readability.\n8. Create a style guide documenting UI components, colors, typography, and usage guidelines.",
                "evaluation_criteria" => "Designs will be judged on visual appeal, usability, information architecture, accessibility, originality, and technical feasibility. Special attention will be given to how complex financial data is represented in a user-friendly manner, and how the design accommodates both novice and expert users.",
            ],
        ]);
        
        // 5. Python Data Analysis Challenge
        Challenge::create([
            "name" => "Python Data Analysis: Climate Change Trends",
            "description" => "Analyze global climate data to identify trends and patterns using Python data science libraries.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(14),
            "points_reward" => 280,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 35,
            "required_level" => 4,
            "challenge_type" => "algorithm",
            "time_limit" => 180, // 3 hours
            "programming_language" => "python",
            "tech_category" => "data_science",
            "challenge_content" => [
                "problem_statement" => "As a data scientist for an environmental research organization, you're tasked with analyzing climate data from the past 50 years to identify significant trends and patterns. You have access to datasets containing global temperature records, CO2 emissions, sea level measurements, and extreme weather events.\n\nYour analysis should include data cleaning, exploratory data analysis, statistical testing, and visualization of key findings. The goal is to create a comprehensive report that highlights the most significant climate changes and potential correlations between different environmental factors.",
                "algorithm_type" => "data_analysis",
                "example" => "Input:\n- global_temperatures.csv: Monthly average temperatures by region (1970-2023)\n- co2_emissions.csv: Annual CO2 emissions by country and sector (1970-2023)\n- sea_levels.csv: Sea level measurements from coastal stations (1970-2023)\n- extreme_weather.csv: Records of floods, droughts, hurricanes by region and intensity (1970-2023)\n\nExpected Output:\n- Cleaned and normalized dataset\n- Statistical analysis of temperature trends by decade and region\n- Correlation analysis between CO2 emissions and temperature changes\n- Time series visualization of key metrics\n- Regression models predicting future trends\n- Interactive dashboard for exploring the data\n- Comprehensive report of findings with visualizations",
                "solution_approach" => "Your solution should utilize Python's data science ecosystem, including pandas for data manipulation, NumPy for numerical operations, SciPy for statistical analysis, scikit-learn for predictive modeling, and Matplotlib/Seaborn/Plotly for visualization. You should implement robust data cleaning procedures to handle missing values and outliers, conduct thorough exploratory data analysis, and apply appropriate statistical tests to validate your findings. The visualization component should include both static plots for the report and interactive elements for the dashboard.",
            ],
        ]);
        
        // 6. Java API Development Challenge
        Challenge::create([
            "name" => "Java Spring Boot API Development",
            "description" => "Design and implement a RESTful API for an inventory management system using Java Spring Boot.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(21),
            "points_reward" => 320,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 30,
            "required_level" => 5,
            "challenge_type" => "coding_challenge",
            "time_limit" => 210, // 3.5 hours
            "programming_language" => "java",
            "tech_category" => "backend",
            "challenge_content" => [
                "scenario" => "A retail company is modernizing its inventory management system and needs a robust RESTful API to handle inventory operations. The API will be used by both internal staff applications and external vendor systems to track product inventory, manage warehouse locations, process orders, and generate reports.\n\nThe system should support role-based access control, robust error handling, comprehensive logging, and must be designed to handle high volumes of concurrent requests. The API must follow REST best practices and include appropriate documentation.",
                "requirements" => "1. Create a Spring Boot application with appropriate structure and dependencies\n2. Implement JPA entities for products, categories, warehouses, inventory levels, and transactions\n3. Design RESTful endpoints following API best practices\n4. Implement service layer with business logic and data validation\n5. Configure Spring Security for authentication and authorization\n6. Include comprehensive exception handling and error responses\n7. Add Swagger/OpenAPI documentation\n8. Write unit and integration tests\n9. Implement caching strategies for performance optimization\n10. Include audit logging for inventory changes",
                "api_endpoints" => "Required API endpoints:\n\n- Products:\n  * GET /api/products - List all products with pagination and filtering\n  * GET /api/products/{id} - Get product details\n  * POST /api/products - Add new product\n  * PUT /api/products/{id} - Update product\n  * DELETE /api/products/{id} - Delete product\n\n- Inventory:\n  * GET /api/inventory?warehouseId={id} - Get inventory levels by warehouse\n  * GET /api/inventory/{productId} - Get inventory for specific product across all warehouses\n  * POST /api/inventory/transaction - Record inventory movement (receiving, shipping, adjustment)\n\n- Warehouses:\n  * GET /api/warehouses - List all warehouses\n  * POST /api/warehouses - Add new warehouse\n\n- Reports:\n  * GET /api/reports/low-stock - Get products with inventory below threshold\n  * GET /api/reports/inventory-value - Get total inventory value by warehouse\n  * GET /api/reports/transactions - Get transaction history with filtering",
                "tech_stack" => "Required technologies:\n- Java 17+\n- Spring Boot 3.x\n- Spring Data JPA\n- Spring Security\n- Hibernate\n- Maven/Gradle\n- H2/PostgreSQL\n- JUnit 5\n- Mockito\n- Swagger/OpenAPI\n- Lombok (optional)",
            ],
        ]);
        
        // 7. PHP Web Application Challenge
        Challenge::create([
            "name" => "PHP Laravel Content Management System",
            "description" => "Build a modern content management system with Laravel for a digital publishing company.",
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDays(17),
            "points_reward" => 290,
            "difficulty_level" => "intermediate",
            "is_active" => true,
            "max_participants" => 35,
            "required_level" => 4,
            "challenge_type" => "coding_challenge",
            "time_limit" => 240, // 4 hours
            "programming_language" => "php",
            "tech_category" => "web_dev",
            "challenge_content" => [
                "scenario" => "A digital publishing company needs a modern content management system to handle their growing catalog of articles, blogs, and digital media. They require a system that allows content editors to create, edit, and publish content with rich media support, category management, and scheduled publishing. The system should also include user management with different permission levels, content workflow states, and basic analytics.",
                "requirements" => "1. Create a Laravel application with appropriate MVC architecture\n2. Implement user authentication with role-based permissions (Admin, Editor, Author, Subscriber)\n3. Design database models for content types, categories, tags, media, and users\n4. Create an admin dashboard for content and user management\n5. Implement a WYSIWYG editor for content creation with image/media uploads\n6. Add content workflow (Draft, Review, Published, Archived)\n7. Implement scheduled publishing and content expiration\n8. Create a public-facing content display with search, filtering, and pagination\n9. Add SEO features including metadata management and sitemap generation\n10. Implement basic analytics to track content views and popular articles",
                "application_features" => "Core features to implement:\n\n- Content Management:\n  * Rich text editor with media embedding\n  * Category and tag management\n  * Content versioning and revision history\n  * Content scheduling and expiration\n  * Bulk operations for content management\n\n- User System:\n  * Role-based permissions\n  * User profiles and activity tracking\n  * Content ownership and collaboration\n\n- Media Library:\n  * Image upload and management\n  * Video and document embedding\n  * Responsive image handling\n\n- Frontend Features:\n  * Responsive content display\n  * Advanced search with filters\n  * Related content suggestions\n  * Social media sharing\n  * Comment system\n\n- Analytics:\n  * Content view tracking\n  * Popular content reporting\n  * User engagement metrics",
                "tech_stack" => "Required technologies:\n- PHP 8.x\n- Laravel 10.x\n- MySQL/PostgreSQL\n- Blade templates\n- Livewire (optional)\n- Laravel Mix for assets\n- Bootstrap or Tailwind CSS\n- JavaScript/Alpine.js\n- Laravel Sanctum/Fortify/Breeze\n- PHPUnit for testing",
            ],
        ]);
    }
}