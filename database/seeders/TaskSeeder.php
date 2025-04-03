<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Challenge;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the challenges
        $securityChallenge = Challenge::where('name', 'Web Security Vulnerability Assessment')->first();
        $algorithmChallenge = Challenge::where('name', 'Product Recommendation Algorithm')->first();
        $databaseChallenge = Challenge::where('name', 'Healthcare Database Design Challenge')->first();
        $uiChallenge = Challenge::where('name', 'Financial Analytics Dashboard UI/UX Challenge')->first();
        $pythonChallenge = Challenge::where('name', 'Python Data Analysis: Climate Change Trends')->first();
        $javaChallenge = Challenge::where('name', 'Java Spring Boot API Development')->first();
        $phpChallenge = Challenge::where('name', 'PHP Laravel Content Management System')->first();

        // Tasks for the Security Vulnerability Assessment Challenge
        if ($securityChallenge) {
            Task::create([
                'name' => 'SQL Injection Prevention',
                'description' => 'Fix the SQL injection vulnerability in the searchUsers function by implementing parameterized queries.',
                'points_reward' => 50,
                'instructions' => 'Please follow standard procedures for fixing SQL injection.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                
                'order' => 1,
            ]);

            Task::create([
                'name' => 'CSRF Token Implementation',
                'description' => 'Enhance the login form with CSRF protection by adding a token to prevent cross-site request forgery attacks.',
                'points_reward' => 60,
                'instructions' => 'Implement CSRF token using standard Laravel methods.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                
                'order' => 2,
            ]);

            Task::create([
                'name' => 'XSS Prevention',
                'description' => 'Update the displayUserProfile function to sanitize user data before output to prevent cross-site scripting attacks.',
                'points_reward' => 70,
                'instructions' => 'Sanitize user inputs to prevent XSS.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Secure Password Reset',
                'description' => 'Implement a secure password reset function that uses password hashing and doesn\'t email plaintext passwords.',
                'points_reward' => 80,
                'instructions' => 'Ensure password reset follows security best practices.',
                'submission_type' => 'code',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                
                'order' => 4,
            ]);
        }

        // Tasks for the Algorithm Challenge
        if ($algorithmChallenge) {
            Task::create([
                'name' => 'Data Preprocessing',
                'description' => 'Implement functions to clean and preprocess the raw user data and product data for use in the recommendation algorithm.',
                'points_reward' => 60,
                'instructions' => 'Clean and prepare the provided dataset.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Similarity Calculation',
                'description' => 'Develop a function that calculates similarity scores between products based on their attributes and usage patterns.',
                'points_reward' => 70,
                'instructions' => 'Implement a product similarity calculation function.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Collaborative Filtering Implementation',
                'description' => 'Create a collaborative filtering component that identifies patterns in user purchasing behaviors to make recommendations.',
                'points_reward' => 80,
                'instructions' => 'Build the collaborative filtering mechanism.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Hybrid Recommendation System',
                'description' => 'Combine content-based and collaborative filtering approaches into a hybrid system that delivers personalized recommendations.',
                'points_reward' => 90,
                'instructions' => 'Develop a hybrid recommendation engine.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                
                'order' => 4,
            ]);
        }

        // Tasks for the Database Challenge
        if ($databaseChallenge) {
            Task::create([
                'name' => 'Medical Records Schema Design',
                'description' => 'Design the tables for storing patient medical records, including visit history, diagnoses, and treatment plans.',
                'points_reward' => 70,
                'instructions' => 'Provide the SQL schema design.',
                'submission_type' => 'file',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Prescription Management System',
                'description' => 'Implement the database schema and stored procedures for managing medication prescriptions, dosages, and refills.',
                'points_reward' => 80,
                'instructions' => 'Implement the prescription management schema and procedures.',
                'submission_type' => 'file',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Billing and Insurance Integration',
                'description' => 'Design the tables and relationships for the billing system that integrates with insurance providers.',
                'points_reward' => 90,
                'instructions' => 'Design the billing and insurance integration schema.',
                'submission_type' => 'file',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Reporting and Analytics Views',
                'description' => 'Create SQL views and functions for generating reports and analytics dashboards for hospital administration.',
                'points_reward' => 110,
                'instructions' => 'Create necessary SQL views and functions for reporting.',
                'submission_type' => 'code',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                
                'order' => 4,
            ]);
        }

        // Tasks for the UI/UX Challenge
        if ($uiChallenge) {
            Task::create([
                'name' => 'Main Dashboard Wireframe',
                'description' => 'Create wireframes for the main portfolio dashboard showing layout for key financial metrics and portfolio overview.',
                'points_reward' => 55,
                'instructions' => 'Submit wireframes for the main dashboard.',
                'submission_type' => 'url',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Asset Allocation Visualization',
                'description' => 'Design the data visualization components for displaying asset allocation, including charts and interactive elements.',
                'points_reward' => 70,
                'instructions' => 'Design visualizations for asset allocation.',
                'submission_type' => 'url',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Mobile Responsive Design',
                'description' => 'Create the responsive design specifications for the dashboard on mobile devices, ensuring all critical information is accessible.',
                'points_reward' => 75,
                'instructions' => 'Provide mobile responsive design specifications.',
                'submission_type' => 'file',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                
                'order' => 3,
            ]);

            Task::create([
                'name' => 'UI Component Style Guide',
                'description' => 'Develop a comprehensive style guide for all UI components including typography, colors, form elements, and interactions.',
                'points_reward' => 75,
                'instructions' => 'Submit the UI component style guide.',
                'submission_type' => 'file',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                
                'order' => 4,
            ]);
        }
        
        // Tasks for the Python Data Analysis Challenge
        if ($pythonChallenge) {
            Task::create([
                'name' => 'Data Loading and Cleaning',
                'description' => 'Write a Python function to load the climate dataset from CSV and clean missing or invalid values.',
                'points_reward' => 60,
                'instructions' => 'Implement Python function for data loading and cleaning.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                
                
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Temperature Trend Visualization',
                'description' => 'Create visualizations showing global temperature changes over the past century.',
                'points_reward' => 70,
                'instructions' => 'Generate temperature trend visualizations.',
                'submission_type' => 'file',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                
                'order' => 2,
            ]);

            Task::create([
                'name' => 'CO2 Emissions Analysis',
                'description' => 'Write functions to analyze CO2 emissions by country and identify the top contributors.',
                'points_reward' => 75,
                'instructions' => 'Implement Python functions for CO2 analysis.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Predictive Model for Future Trends',
                'description' => 'Develop a simple predictive model to forecast temperature changes for the next decade.',
                'points_reward' => 85,
                'instructions' => 'Build a predictive model for temperature trends.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                
                'order' => 4,
            ]);
        }
        
        // Tasks for the Java Spring Boot API Challenge
        if ($javaChallenge) {
            Task::create([
                'name' => 'API Project Setup and Entity Modeling',
                'description' => 'Set up a Spring Boot project and define JPA entities for the inventory management system, including relationships between models.',
                'points_reward' => 65,
                'instructions' => 'Set up the project and define JPA entities.',
                'submission_type' => 'code',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
                
                'order' => 1,
            ]);

            Task::create([
                'name' => 'REST Controller Implementation',
                'description' => 'Create REST controllers with CRUD endpoints for products, inventory, and warehouses following REST best practices.',
                'points_reward' => 75,
                'instructions' => 'Implement REST controllers for the API.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
               
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Service Layer and Business Logic',
                'description' => 'Implement the service layer with business logic for inventory management, including validation and transaction processing.',
                'points_reward' => 85,
                'instructions' => 'Implement the service layer and business logic.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
                
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Security and Documentation Implementation',
                'description' => 'Configure Spring Security for role-based authentication and add Swagger/OpenAPI documentation for all endpoints.',
                'points_reward' => 95,
                'instructions' => 'Implement security and API documentation.',
                'submission_type' => 'code',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
                
                'order' => 4,
            ]);
        }
        
        // Tasks for the PHP Laravel CMS Challenge
        if ($phpChallenge) {
            Task::create([
                'name' => 'CMS Models and Migration Setup',
                'description' => 'Create the database models, migrations, and relationships for content types, users, and media.',
                'points_reward' => 60,
                'instructions' => 'Set up CMS models and migrations.',
                'submission_type' => 'code',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                
                'order' => 1,
            ]);

            Task::create([
                'name' => 'User Authentication and Authorization',
                'description' => 'Implement user authentication with role-based permissions for content management (Admin, Editor, Author, Subscriber).',
                'points_reward' => 70,
                'instructions' => 'Implement user authentication and authorization.',
                'submission_type' => 'code',
                'evaluation_type' => 'automated',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Content Management Controllers',
                'description' => 'Create controllers and views for content creation, editing, publishing, and scheduling with media uploads.',
                'points_reward' => 80,
                'instructions' => 'Implement content management controllers and views.',
                'submission_type' => 'code',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Frontend Display and SEO Features',
                'description' => 'Build the public-facing content display with search functionality, SEO features, and a responsive design.',
                'points_reward' => 90,
                'instructions' => 'Implement frontend display and SEO features.',
                'submission_type' => 'code',
                'evaluation_type' => 'manual',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                
                'order' => 4,
            ]);
        }

        // General tasks (keeping some originals)
        Task::create([
            'name' => 'Daily Check-in',
            'description' => 'Check in to the application once per day',
            'points_reward' => 10,
            'instructions' => 'Simply log in daily.',
            'submission_type' => 'automatic',
            'evaluation_type' => 'automated',
            'is_active' => true,
            
        ]);

        Task::create([
            'name' => 'Weekly Challenge',
            'description' => 'Complete a difficult weekly challenge',
            'points_reward' => 50,
            'instructions' => 'Complete the designated weekly challenge.',
            'submission_type' => 'automatic',
            'evaluation_type' => 'automated',
            'is_active' => true,
           
        ]);

        Task::create([
            'name' => 'Profile Setup',
            'description' => 'Complete your user profile',
            'points_reward' => 20,
            'instructions' => 'Fill out all fields in your user profile.',
            'submission_type' => 'automatic',
            'evaluation_type' => 'automated',
            'is_active' => true,
            
        ]);
    }
}
