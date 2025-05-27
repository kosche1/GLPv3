<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\HelpArticle;
use App\Models\HelpCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class HelpCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user or create a default one
        $adminUser = User::first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Create help categories
        $gettingStarted = HelpCategory::create([
            'name' => 'Getting Started',
            'slug' => 'getting-started',
            'description' => 'Learn the basics and get up to speed with our platform features',
            'icon' => 'book-open',
            'color' => '#10b981',
            'sort_order' => 1,
        ]);

        $accountManagement = HelpCategory::create([
            'name' => 'Account Management',
            'slug' => 'account-management',
            'description' => 'Manage your account settings and profile information',
            'icon' => 'user-circle',
            'color' => '#3b82f6',
            'sort_order' => 2,
        ]);

        $courseAccess = HelpCategory::create([
            'name' => 'Course Access',
            'slug' => 'course-access',
            'description' => 'Access your courses and learning materials',
            'icon' => 'academic-cap',
            'color' => '#8b5cf6',
            'sort_order' => 3,
        ]);

        $technicalSupport = HelpCategory::create([
            'name' => 'Technical Support',
            'slug' => 'technical-support',
            'description' => 'Get help with technical issues and troubleshooting',
            'icon' => 'cog',
            'color' => '#f59e0b',
            'sort_order' => 4,
        ]);

        // Create FAQs
        $faqs = [
            [
                'category' => $accountManagement,
                'question' => 'How do I reset my password?',
                'answer' => 'To reset your password, click on the "Forgot Password" link on the login page. Enter your email address, and we\'ll send you a password reset link. Follow the instructions in the email to create a new password.',
                'is_featured' => true,
            ],
            [
                'category' => $courseAccess,
                'question' => 'How do I access my course materials?',
                'answer' => 'After logging in, navigate to the "My Courses" section in your dashboard. Click on the course you want to access, and you\'ll be taken to the course homepage where you can find all materials, lectures, assignments, and resources for that course.',
                'is_featured' => true,
            ],
            [
                'category' => $courseAccess,
                'question' => 'How do I submit assignments?',
                'answer' => 'To submit an assignment, go to the specific course page, find the assignment section, and click on the assignment you want to submit. You\'ll see a "Submit Assignment" button where you can upload your files or type your answers, depending on the assignment type.',
                'is_featured' => true,
            ],
            [
                'category' => $courseAccess,
                'question' => 'How do I get a certificate for completed courses?',
                'answer' => 'Once you\'ve completed all the required components of a course (lectures, assignments, quizzes, etc.), a certificate will automatically be generated. You can access and download your certificates from the "Achievements" or "Certificates" section in your profile.',
                'is_featured' => true,
            ],
            [
                'category' => $accountManagement,
                'question' => 'How do I update my profile information?',
                'answer' => 'Go to your profile settings by clicking on your avatar in the top right corner and selecting "Profile Settings". From there, you can update your personal information, contact details, and preferences.',
                'is_featured' => false,
            ],
            [
                'category' => $technicalSupport,
                'question' => 'Why is my video not playing correctly?',
                'answer' => 'Video playback issues can be caused by several factors: slow internet connection, browser compatibility, or outdated plugins. Try refreshing the page, clearing your browser cache, or switching to a different browser. If the problem persists, contact our technical support team.',
                'is_featured' => false,
            ],
        ];

        foreach ($faqs as $faqData) {
            Faq::create([
                'help_category_id' => $faqData['category']->id,
                'question' => $faqData['question'],
                'answer' => $faqData['answer'],
                'is_featured' => $faqData['is_featured'],
                'created_by' => $adminUser->id,
            ]);
        }

        // Create help articles
        $articles = [
            [
                'category' => $gettingStarted,
                'title' => 'Platform Overview',
                'content' => '<h2>Welcome to Our Learning Platform</h2><p>Our platform is designed to provide you with a comprehensive learning experience. Here\'s what you can expect:</p><ul><li>Interactive courses and challenges</li><li>Real-time progress tracking</li><li>Community forums and discussions</li><li>Personalized learning paths</li></ul><p>Navigate through the dashboard to explore all available features and start your learning journey today!</p>',
                'is_featured' => true,
            ],
            [
                'category' => $gettingStarted,
                'title' => 'Creating Your Account',
                'content' => '<h2>Getting Started</h2><p>Creating an account is simple and takes just a few minutes:</p><ol><li>Click the "Sign Up" button on the homepage</li><li>Fill in your personal information</li><li>Verify your email address</li><li>Complete your profile setup</li></ol><p>Once your account is created, you\'ll have access to all platform features and can start exploring courses immediately.</p>',
                'is_featured' => true,
            ],
            [
                'category' => $accountManagement,
                'title' => 'Managing Notification Settings',
                'content' => '<h2>Customize Your Notifications</h2><p>Stay informed about important updates while avoiding notification overload:</p><ul><li>Email notifications for course updates</li><li>Push notifications for deadlines</li><li>Weekly progress summaries</li><li>Community activity alerts</li></ul><p>Access notification settings from your profile menu to customize your preferences.</p>',
                'is_featured' => false,
            ],
        ];

        foreach ($articles as $articleData) {
            HelpArticle::create([
                'help_category_id' => $articleData['category']->id,
                'title' => $articleData['title'],
                'content' => $articleData['content'],
                'is_featured' => $articleData['is_featured'],
                'created_by' => $adminUser->id,
                'published_at' => now(),
            ]);
        }
    }
}
