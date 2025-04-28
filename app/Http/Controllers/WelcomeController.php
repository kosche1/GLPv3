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

        // Get 2 subjects from each specialized track
        $technologies = [];

        // STEM subjects
        $stemSubjects = Challenge::where('subject_type', 'specialized')
            ->where('tech_category', 'stem')
            ->where('is_active', true)
            ->take(2)
            ->get();

        foreach ($stemSubjects as $subject) {
            $technologies[] = [
                'name' => $subject->name,
                'icon' => 'stem',
                'color' => 'blue',
                'count' => $subject->tasks()->count(),
                'strand' => 'STEM'
            ];
        }

        // ABM subjects
        $abmSubjects = Challenge::where('subject_type', 'specialized')
            ->where('tech_category', 'abm')
            ->where('is_active', true)
            ->take(2)
            ->get();

        foreach ($abmSubjects as $subject) {
            $technologies[] = [
                'name' => $subject->name,
                'icon' => 'abm',
                'color' => 'amber',
                'count' => $subject->tasks()->count(),
                'strand' => 'ABM'
            ];
        }

        // HUMSS subjects
        $humssSubjects = Challenge::where('subject_type', 'specialized')
            ->where('tech_category', 'humms')
            ->where('is_active', true)
            ->take(2)
            ->get();

        foreach ($humssSubjects as $subject) {
            $technologies[] = [
                'name' => $subject->name,
                'icon' => 'humms',
                'color' => 'purple',
                'count' => $subject->tasks()->count(),
                'strand' => 'HUMSS'
            ];
        }

        // HE subjects
        $heSubjects = Challenge::where('subject_type', 'specialized')
            ->where('tech_category', 'he')
            ->where('is_active', true)
            ->take(2)
            ->get();

        foreach ($heSubjects as $subject) {
            $technologies[] = [
                'name' => $subject->name,
                'icon' => 'he',
                'color' => 'pink',
                'count' => $subject->tasks()->count(),
                'strand' => 'HE'
            ];
        }

        // ICT subjects
        $ictSubjects = Challenge::where('subject_type', 'specialized')
            ->where('tech_category', 'ict')
            ->where('is_active', true)
            ->take(2)
            ->get();

        foreach ($ictSubjects as $subject) {
            $technologies[] = [
                'name' => $subject->name,
                'icon' => 'ict',
                'color' => 'emerald',
                'count' => $subject->tasks()->count(),
                'strand' => 'ICT'
            ];
        }

        return view('welcome', compact('challenges', 'stats', 'learningPaths', 'technologies'));
    }
}
