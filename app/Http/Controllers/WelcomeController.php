<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\User;
use App\Models\Category;
use App\Models\StudentAttendance;
use App\Models\StudentAnswer;
use App\Models\UserTask;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with dynamic data
     */
    public function index()
    {
        // Get featured challenges
        $challenges = Challenge::orderBy('id')->take(3)->get();
        
        // Get statistics for counter section
        $stats = [
            'users' => User::count(),
            'courses' => Challenge::count(),
            'completedTasks' => UserTask::where('completed', true)->count(),
            'achievements' => DB::table('achievement_user')->count(),
        ];
        
        // Get learning paths/steps
        $learningPaths = [
            [
                'step' => 1,
                'title' => 'Create an Account',
                'description' => 'Sign up and set up your profile to start your learning journey.'
            ],
            [
                'step' => 2,
                'title' => 'Choose Your Path',
                'description' => 'Select from various courses and challenges based on your interests and skill level.'
            ],
            [
                'step' => 3,
                'title' => 'Learn & Earn',
                'description' => 'Complete challenges, earn points, unlock achievements, and track your progress.'
            ]
        ];
        
        // Get technologies taught
        $technologies = [
            [
                'name' => 'JavaScript',
                'icon' => 'javascript',
                'color' => 'yellow',
                'count' => Challenge::where('programming_language', 'javascript')->count()
            ],
            [
                'name' => 'Python',
                'icon' => 'python',
                'color' => 'blue',
                'count' => Challenge::where('programming_language', 'python')->count()
            ],
            [
                'name' => 'Java',
                'icon' => 'java',
                'color' => 'orange',
                'count' => Challenge::where('programming_language', 'java')->count()
            ],
            [
                'name' => 'C#',
                'icon' => 'csharp',
                'color' => 'purple',
                'count' => Challenge::where('programming_language', 'csharp')->count()
            ],
            [
                'name' => 'PHP',
                'icon' => 'php',
                'color' => 'indigo',
                'count' => Challenge::where('programming_language', 'php')->count()
            ],
            [
                'name' => 'SQL',
                'icon' => 'database',
                'color' => 'emerald',
                'count' => Challenge::where('programming_language', 'sql')->count()
            ]
        ];
        
        return view('welcome', compact('challenges', 'stats', 'learningPaths', 'technologies'));
    }
}
