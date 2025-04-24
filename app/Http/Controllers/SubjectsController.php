<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Challenge;
use App\Models\Category;

class SubjectsController extends Controller
{
    /**
     * Display the Core Subjects page
     */
    public function coreSubjects(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'core')
            ->orderBy('required_level', 'asc')
            ->get();

        // Get completed challenges for the current user
        $completedChallenges = [];
        if (Auth::check()) {
            $userId = Auth::id();

            foreach ($challenges as $challenge) {
                $totalTasks = $challenge->tasks->count();
                if ($totalTasks > 0) {
                    $completedTasks = \App\Models\StudentAnswer::where('user_id', $userId)
                        ->whereIn('task_id', $challenge->tasks->pluck('id'))
                        ->count();

                    // If all tasks are completed, mark the challenge as completed
                    if ($completedTasks >= $totalTasks) {
                        $completedChallenges[] = $challenge->id;
                    }
                }
            }
        }

        return view('subjects.core-subjects', [
            'challenges' => $challenges,
            'subjectType' => 'Core',
            'completedChallenges' => $completedChallenges
        ]);
    }

    /**
     * Display the Applied Subjects page
     */
    public function appliedSubjects(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'applied')
            ->orderBy('required_level', 'asc')
            ->get();

        // Get completed challenges for the current user
        $completedChallenges = [];
        if (Auth::check()) {
            $userId = Auth::id();

            foreach ($challenges as $challenge) {
                $totalTasks = $challenge->tasks->count();
                if ($totalTasks > 0) {
                    $completedTasks = \App\Models\StudentAnswer::where('user_id', $userId)
                        ->whereIn('task_id', $challenge->tasks->pluck('id'))
                        ->count();

                    // If all tasks are completed, mark the challenge as completed
                    if ($completedTasks >= $totalTasks) {
                        $completedChallenges[] = $challenge->id;
                    }
                }
            }
        }

        return view('subjects.applied-subjects', [
            'challenges' => $challenges,
            'subjectType' => 'Applied',
            'completedChallenges' => $completedChallenges
        ]);
    }

    /**
     * Display the Specialized Subjects page
     */
    public function specializedSubjects(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'specialized')
            ->orderBy('required_level', 'asc')
            ->get();

        // Get completed challenges for the current user
        $completedChallenges = [];
        if (Auth::check()) {
            $userId = Auth::id();

            foreach ($challenges as $challenge) {
                $totalTasks = $challenge->tasks->count();
                if ($totalTasks > 0) {
                    $completedTasks = \App\Models\StudentAnswer::where('user_id', $userId)
                        ->whereIn('task_id', $challenge->tasks->pluck('id'))
                        ->count();

                    // If all tasks are completed, mark the challenge as completed
                    if ($completedTasks >= $totalTasks) {
                        $completedChallenges[] = $challenge->id;
                    }
                }
            }
        }

        return view('subjects.specialized-subjects', [
            'challenges' => $challenges,
            'subjectType' => 'Specialized',
            'completedChallenges' => $completedChallenges
        ]);
    }
}
