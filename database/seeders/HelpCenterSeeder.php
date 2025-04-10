<?php

namespace Database\Seeders;

use App\Models\HelpCategory;
use App\Models\HelpArticle;
use App\Models\Faq;
use Illuminate\Database\Seeder;

class HelpCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create help categories
        $gettingStarted = HelpCategory::create([
            'name' => 'Getting Started',
            'slug' => 'getting-started',
            'description' => 'Learn the basics and get up to speed with our platform features',
            'icon' => 'book-open',
            'color' => 'emerald',
            'order' => 1,
            'is_active' => true,
        ]);

        $accountManagement = HelpCategory::create([
            'name' => 'Account Management',
            'slug' => 'account-management',
            'description' => 'Manage your account settings and preferences',
            'icon' => 'user-circle',
            'color' => 'blue',
            'order' => 2,
            'is_active' => true,
        ]);

        $courseAccess = HelpCategory::create([
            'name' => 'Course Access',
            'slug' => 'course-access',
            'description' => 'Access and navigate through your courses',
            'icon' => 'academic-cap',
            'color' => 'purple',
            'order' => 3,
            'is_active' => true,
        ]);

        $technicalSupport = HelpCategory::create([
            'name' => 'Technical Support',
            'slug' => 'technical-support',
            'description' => 'Get help with technical issues',
            'icon' => 'cog',
            'color' => 'red',
            'order' => 4,
            'is_active' => true,
        ]);

        // Create help articles
        HelpArticle::create([
            'title' => 'Platform Overview',
            'slug' => 'platform-overview',
            'content' => '<p>Welcome to GameLearnPro! This platform is designed to help you learn through interactive gaming experiences. Here\'s a quick overview of what you can expect:</p>
                        <h3>Key Features</h3>
                        <ul>
                            <li>Interactive learning challenges</li>
                            <li>Progress tracking and achievements</li>
                            <li>Community forums for discussion</li>
                            <li>Personalized learning paths</li>
                        </ul>
                        <p>To get started, navigate to the Challenges section and choose a challenge that interests you. Complete tasks to earn points and unlock achievements.</p>',
            'help_category_id' => $gettingStarted->id,
            'is_featured' => true,
            'is_published' => true,
            'created_by' => null,
            'updated_by' => null,
        ]);

        HelpArticle::create([
            'title' => 'Creating Your Account',
            'slug' => 'creating-your-account',
            'content' => '<p>Setting up your account on GameLearnPro is quick and easy. Follow these steps to get started:</p>
                        <ol>
                            <li>Click on the "Register" button in the top right corner of the homepage</li>
                            <li>Enter your email address and create a secure password</li>
                            <li>Fill in your profile information</li>
                            <li>Verify your email address by clicking the link sent to your inbox</li>
                            <li>Log in with your new credentials</li>
                        </ol>
                        <p>Once your account is created, you can customize your profile, set preferences, and start exploring challenges.</p>',
            'help_category_id' => $gettingStarted->id,
            'is_featured' => false,
            'is_published' => true,
            'created_by' => null,
            'updated_by' => null,
        ]);

        HelpArticle::create([
            'title' => 'How to Reset Your Password',
            'slug' => 'how-to-reset-your-password',
            'content' => '<p>If you\'ve forgotten your password, don\'t worry! You can easily reset it by following these steps:</p>
                        <ol>
                            <li>Click on the "Login" button in the top right corner of the homepage</li>
                            <li>Click on the "Forgot Password" link below the login form</li>
                            <li>Enter the email address associated with your account</li>
                            <li>Check your email for a password reset link</li>
                            <li>Click the link and follow the instructions to create a new password</li>
                            <li>Log in with your new password</li>
                        </ol>
                        <p>For security reasons, password reset links expire after 24 hours. If you don\'t reset your password within this timeframe, you\'ll need to request a new link.</p>',
            'help_category_id' => $accountManagement->id,
            'is_featured' => true,
            'is_published' => true,
            'created_by' => null,
            'updated_by' => null,
        ]);

        HelpArticle::create([
            'title' => 'Accessing Course Materials',
            'slug' => 'accessing-course-materials',
            'content' => '<p>GameLearnPro provides easy access to all your course materials. Here\'s how to find and use them:</p>
                        <h3>Finding Your Courses</h3>
                        <ol>
                            <li>Log in to your account</li>
                            <li>Navigate to the "My Courses" section in your dashboard</li>
                            <li>Click on the course you want to access</li>
                        </ol>
                        <h3>Navigating Course Content</h3>
                        <p>Once you\'ve opened a course, you\'ll see:</p>
                        <ul>
                            <li>Course modules and lessons</li>
                            <li>Assignments and quizzes</li>
                            <li>Supplementary resources</li>
                            <li>Discussion forums specific to the course</li>
                        </ul>
                        <p>You can track your progress through the course using the progress bar at the top of the page.</p>',
            'help_category_id' => $courseAccess->id,
            'is_featured' => true,
            'is_published' => true,
            'created_by' => null,
            'updated_by' => null,
        ]);

        HelpArticle::create([
            'title' => 'Troubleshooting Common Issues',
            'slug' => 'troubleshooting-common-issues',
            'content' => '<p>If you\'re experiencing technical issues with GameLearnPro, here are some common solutions:</p>
                        <h3>Browser Issues</h3>
                        <ul>
                            <li>Make sure your browser is up to date</li>
                            <li>Clear your browser cache and cookies</li>
                            <li>Try using a different browser (Chrome, Firefox, Edge, or Safari)</li>
                            <li>Disable browser extensions that might interfere with the platform</li>
                        </ul>
                        <h3>Connection Issues</h3>
                        <ul>
                            <li>Check your internet connection</li>
                            <li>Try connecting to a different network</li>
                            <li>Restart your router or modem</li>
                        </ul>
                        <h3>Still Having Problems?</h3>
                        <p>If you\'re still experiencing issues, please contact our technical support team through the Technical Support page.</p>',
            'help_category_id' => $technicalSupport->id,
            'is_featured' => true,
            'is_published' => true,
            'created_by' => null,
            'updated_by' => null,
        ]);

        // Create FAQs
        Faq::create([
            'question' => 'How do I reset my password?',
            'answer' => 'To reset your password, click on the "Forgot Password" link on the login page. Enter your email address, and we\'ll send you a password reset link. Follow the instructions in the email to create a new password.',
            'help_category_id' => $accountManagement->id,
            'order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'How do I access my course materials?',
            'answer' => 'After logging in, navigate to the "My Courses" section in your dashboard. Click on the course you want to access, and you\'ll be taken to the course homepage where you can find all materials, lectures, assignments, and resources for that course.',
            'help_category_id' => $courseAccess->id,
            'order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'How do I submit assignments?',
            'answer' => 'To submit an assignment, go to the specific course page, find the assignment section, and click on the assignment you want to submit. You\'ll see a "Submit Assignment" button where you can upload your files or type your answers, depending on the assignment type.',
            'help_category_id' => $courseAccess->id,
            'order' => 2,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'How do I get a certificate for completed courses?',
            'answer' => 'Once you\'ve completed all the required components of a course (lectures, assignments, quizzes, etc.), a certificate will automatically be generated. You can access and download your certificates from the "Achievements" or "Certificates" section in your profile.',
            'help_category_id' => $courseAccess->id,
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
