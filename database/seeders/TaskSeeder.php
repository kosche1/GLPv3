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
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'expected_solution' => [
                    'function searchUsers($query) {',
                    '    global $db;',
                    '    $stmt = $db->prepare("SELECT * FROM users WHERE username LIKE ?");',
                    '    $searchParam = "%$query%";',
                    '    $stmt->bind_param("s", $searchParam);',
                    '    $stmt->execute();',
                    '    return $stmt->get_result();',
                    '}'
                ],
                'order' => 1,
            ]);

            Task::create([
                'name' => 'CSRF Token Implementation',
                'description' => 'Enhance the login form with CSRF protection by adding a token to prevent cross-site request forgery attacks.',
                'points_reward' => 60,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'expected_solution' => [
                    'function renderLoginForm() {',
                    '    $csrf_token = bin2hex(random_bytes(32));',
                    '    $_SESSION["csrf_token"] = $csrf_token;',
                    '    echo \'<form method="POST" action="/login.php">\';',
                    '    echo \'<input type="hidden" name="csrf_token" value="\' . $csrf_token . \'">\';',
                    '    echo \'<input type="text" name="username" placeholder="Username">\';',
                    '    echo \'<input type="password" name="password" placeholder="Password">\';',
                    '    echo \'<button type="submit">Login</button>\';',
                    '    echo \'</form>\';',
                    '}'
                ],
                'order' => 2,
            ]);

            Task::create([
                'name' => 'XSS Prevention',
                'description' => 'Update the displayUserProfile function to sanitize user data before output to prevent cross-site scripting attacks.',
                'points_reward' => 70,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'expected_solution' => [
                    'function displayUserProfile($userData) {',
                    '    echo \'<h2>Welcome back, \' . htmlspecialchars($userData[\'name\'], ENT_QUOTES, \'UTF-8\') . \'</h2>\';',
                    '    echo \'<div>Bio: \' . htmlspecialchars($userData[\'bio\'], ENT_QUOTES, \'UTF-8\') . \'</div>\';',
                    '    echo \'<div>Website: \' . htmlspecialchars($userData[\'website\'], ENT_QUOTES, \'UTF-8\') . \'</div>\';',
                    '}'
                ],
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Secure Password Reset',
                'description' => 'Implement a secure password reset function that uses password hashing and doesn\'t email plaintext passwords.',
                'points_reward' => 80,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $securityChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'expected_solution' => [
                    'function resetPassword($email) {',
                    '    global $db;',
                    '    $token = bin2hex(random_bytes(32));',
                    '    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));',
                    '    $stmt = $db->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");',
                    '    $stmt->bind_param("sss", $token, $expiry, $email);',
                    '    $stmt->execute();',
                    '    $reset_link = "https://example.com/reset-password.php?token=" . $token;',
                    '    mail($email, "Password Reset", "Click the following link to reset your password: " . $reset_link);',
                    '    return true;',
                    '}'
                ],
                'order' => 4,
            ]);
        }

        // Tasks for the Algorithm Challenge
        if ($algorithmChallenge) {
            Task::create([
                'name' => 'Data Preprocessing',
                'description' => 'Implement functions to clean and preprocess the raw user data and product data for use in the recommendation algorithm.',
                'points_reward' => 60,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Similarity Calculation',
                'description' => 'Develop a function that calculates similarity scores between products based on their attributes and usage patterns.',
                'points_reward' => 70,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Collaborative Filtering Implementation',
                'description' => 'Create a collaborative filtering component that identifies patterns in user purchasing behaviors to make recommendations.',
                'points_reward' => 80,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Hybrid Recommendation System',
                'description' => 'Combine content-based and collaborative filtering approaches into a hybrid system that delivers personalized recommendations.',
                'points_reward' => 90,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $algorithmChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 4,
            ]);
        }

        // Tasks for the Database Challenge
        if ($databaseChallenge) {
            Task::create([
                'name' => 'Medical Records Schema Design',
                'description' => 'Design the tables for storing patient medical records, including visit history, diagnoses, and treatment plans.',
                'points_reward' => 70,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Prescription Management System',
                'description' => 'Implement the database schema and stored procedures for managing medication prescriptions, dosages, and refills.',
                'points_reward' => 80,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Billing and Insurance Integration',
                'description' => 'Design the tables and relationships for the billing system that integrates with insurance providers.',
                'points_reward' => 90,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Reporting and Analytics Views',
                'description' => 'Create SQL views and functions for generating reports and analytics dashboards for hospital administration.',
                'points_reward' => 110,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $databaseChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 4,
            ]);
        }

        // Tasks for the UI/UX Challenge
        if ($uiChallenge) {
            Task::create([
                'name' => 'Main Dashboard Wireframe',
                'description' => 'Create wireframes for the main portfolio dashboard showing layout for key financial metrics and portfolio overview.',
                'points_reward' => 55,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                'completion_criteria' => ['action' => 'design_submission', 'count' => 1],
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Asset Allocation Visualization',
                'description' => 'Design the data visualization components for displaying asset allocation, including charts and interactive elements.',
                'points_reward' => 70,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                'completion_criteria' => ['action' => 'design_submission', 'count' => 1],
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Mobile Responsive Design',
                'description' => 'Create the responsive design specifications for the dashboard on mobile devices, ensuring all critical information is accessible.',
                'points_reward' => 75,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                'completion_criteria' => ['action' => 'design_submission', 'count' => 1],
                'order' => 3,
            ]);

            Task::create([
                'name' => 'UI Component Style Guide',
                'description' => 'Develop a comprehensive style guide for all UI components including typography, colors, form elements, and interactions.',
                'points_reward' => 75,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $uiChallenge->id,
                'completion_criteria' => ['action' => 'design_submission', 'count' => 1],
                'order' => 4,
            ]);
        }
        
        // Tasks for the Python Data Analysis Challenge
        if ($pythonChallenge) {
            Task::create([
                'name' => 'Data Cleaning and Preparation',
                'description' => 'Clean the climate datasets by handling missing values, outliers, and standardizing formats for analysis.',
                'points_reward' => 60,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'expected_solution' => [
                    'import pandas as pd',
                    'import numpy as np',
                    '',
                    'def clean_temperature_data(df):',
                    '    # Handle missing values',
                    '    df = df.fillna(method="ffill")',
                    '    # Remove outliers (values > 3 std from mean)',
                    '    mean, std = df["temperature"].mean(), df["temperature"].std()',
                    '    df = df[(df["temperature"] > mean - 3*std) & (df["temperature"] < mean + 3*std)]',
                    '    # Standardize date format',
                    '    df["date"] = pd.to_datetime(df["date"])',
                    '    return df',
                    '',
                    'def standardize_datasets(temp_df, co2_df, sea_df, weather_df):',
                    '    # Create consistent date index for all datasets',
                    '    # Additional cleaning steps',
                    '    # Return cleaned and aligned datasets',
                    '    return cleaned_temp, cleaned_co2, cleaned_sea, cleaned_weather'
                ],
                'order' => 1,
            ]);

            Task::create([
                'name' => 'Exploratory Data Analysis',
                'description' => 'Conduct exploratory data analysis on the climate datasets, including statistical summaries, trend identification, and initial visualizations.',
                'points_reward' => 70,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Statistical Analysis and Modeling',
                'description' => 'Apply statistical tests and create models to analyze climate trends, including temperature increases by region and correlation with emissions.',
                'points_reward' => 80,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Interactive Dashboard Creation',
                'description' => 'Build an interactive dashboard using Plotly or Dash to visualize climate change findings, allowing for filtering by region and time period.',
                'points_reward' => 90,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $pythonChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 4,
            ]);
        }
        
        // Tasks for the Java Spring Boot API Challenge
        if ($javaChallenge) {
            Task::create([
                'name' => 'API Project Setup and Entity Modeling',
                'description' => 'Set up a Spring Boot project and define JPA entities for the inventory management system, including relationships between models.',
                'points_reward' => 65,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'expected_solution' => [
                    '// Product.java',
                    '@Entity',
                    '@Table(name = "products")',
                    'public class Product {',
                    '    @Id',
                    '    @GeneratedValue(strategy = GenerationType.IDENTITY)',
                    '    private Long id;',
                    '',
                    '    @Column(nullable = false)',
                    '    private String name;',
                    '',
                    '    private String description;',
                    '',
                    '    @Column(nullable = false)',
                    '    private BigDecimal price;',
                    '',
                    '    @ManyToOne',
                    '    @JoinColumn(name = "category_id")',
                    '    private Category category;',
                    '',
                    '    @OneToMany(mappedBy = "product", cascade = CascadeType.ALL)',
                    '    private List<InventoryItem> inventoryItems;',
                    '',
                    '    // Getters, setters, constructors',
                    '}'
                ],
                'order' => 1,
            ]);

            Task::create([
                'name' => 'REST Controller Implementation',
                'description' => 'Create REST controllers with CRUD endpoints for products, inventory, and warehouses following REST best practices.',
                'points_reward' => 75,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Service Layer and Business Logic',
                'description' => 'Implement the service layer with business logic for inventory management, including validation and transaction processing.',
                'points_reward' => 85,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Security and Documentation Implementation',
                'description' => 'Configure Spring Security for role-based authentication and add Swagger/OpenAPI documentation for all endpoints.',
                'points_reward' => 95,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $javaChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 4,
            ]);
        }
        
        // Tasks for the PHP Laravel CMS Challenge
        if ($phpChallenge) {
            Task::create([
                'name' => 'CMS Models and Migration Setup',
                'description' => 'Create the database models, migrations, and relationships for content types, users, and media.',
                'points_reward' => 60,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'expected_solution' => [
                    '// Article.php',
                    'class Article extends Model',
                    '{',
                    '    use HasFactory;',
                    '',
                    '    protected $fillable = [',
                    '        "title",',
                    '        "slug",',
                    '        "content",',
                    '        "excerpt",',
                    '        "featured_image",',
                    '        "status",',
                    '        "published_at",',
                    '        "expires_at",',
                    '        "author_id",',
                    '        "seo_title",',
                    '        "seo_description",',
                    '        "seo_keywords"',
                    '    ];',
                    '',
                    '    protected $casts = [',
                    '        "published_at" => "datetime",',
                    '        "expires_at" => "datetime"',
                    '    ];',
                    '',
                    '    public function author()',
                    '    {',
                    '        return $this->belongsTo(User::class, "author_id");',
                    '    }',
                    '',
                    '    public function categories()',
                    '    {',
                    '        return $this->belongsToMany(Category::class);',
                    '    }',
                    '',
                    '    public function tags()',
                    '    {',
                    '        return $this->belongsToMany(Tag::class);',
                    '    }',
                    '',
                    '    // Scope for published articles',
                    '    public function scopePublished($query)',
                    '    {',
                    '        return $query->where("status", "published")',
                    '            ->where("published_at", "<=", now())',
                    '            ->where(function ($q) {',
                    '                $q->whereNull("expires_at")',
                    '                  ->orWhere("expires_at", ">", now());',
                    '            });',
                    '    }',
                    '}'
                ],
                'order' => 1,
            ]);

            Task::create([
                'name' => 'User Authentication and Authorization',
                'description' => 'Implement user authentication with role-based permissions for content management (Admin, Editor, Author, Subscriber).',
                'points_reward' => 70,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 2,
            ]);

            Task::create([
                'name' => 'Content Management Controllers',
                'description' => 'Create controllers and views for content creation, editing, publishing, and scheduling with media uploads.',
                'points_reward' => 80,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 3,
            ]);

            Task::create([
                'name' => 'Frontend Display and SEO Features',
                'description' => 'Build the public-facing content display with search functionality, SEO features, and a responsive design.',
                'points_reward' => 90,
                'type' => 'challenge',
                'is_active' => true,
                'challenge_id' => $phpChallenge->id,
                'completion_criteria' => ['action' => 'code_submission', 'count' => 1],
                'order' => 4,
            ]);
        }

        // General tasks (keeping some originals)
        Task::create([
            'name' => 'Daily Check-in',
            'description' => 'Check in to the application once per day',
            'points_reward' => 10,
            'type' => 'daily',
            'is_active' => true,
            'completion_criteria' => ['action' => 'login', 'count' => 1],
            'additional_rewards' => null,
        ]);

        Task::create([
            'name' => 'Weekly Challenge',
            'description' => 'Complete a difficult weekly challenge',
            'points_reward' => 50,
            'type' => 'weekly',
            'is_active' => true,
            'completion_criteria' => ['action' => 'challenge', 'count' => 1],
            'additional_rewards' => ['badge_id' => 2],
        ]);

        Task::create([
            'name' => 'Profile Setup',
            'description' => 'Complete your user profile',
            'points_reward' => 20,
            'type' => 'onetime',
            'is_active' => true,
            'completion_criteria' => ['action' => 'profile_complete', 'count' => 1],
            'additional_rewards' => null,
        ]);
    }
}
