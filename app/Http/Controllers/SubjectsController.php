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

    /**
     * Display the ABM (Accountancy, Business, and Management) track page
     */
    public function abmTrack(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'specialized')
            ->where('tech_category', 'abm')
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

        return view('subjects.specialized-tracks.abm', [
            'challenges' => $challenges,
            'trackName' => 'ABM',
            'trackFullName' => 'Accountancy, Business, and Management',
            'completedChallenges' => $completedChallenges
        ]);
    }

    /**
     * Display the HE (Home Economics) track page
     */
    public function heTrack(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'specialized')
            ->where('tech_category', 'he')
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

        return view('subjects.specialized-tracks.he', [
            'challenges' => $challenges,
            'trackName' => 'HE',
            'trackFullName' => 'Home Economics',
            'completedChallenges' => $completedChallenges
        ]);
    }

    /**
     * Display the HUMMS (Humanities and Social Sciences) track page
     */
    public function hummsTrack(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'specialized')
            ->where('tech_category', 'humms')
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

        return view('subjects.specialized-tracks.humms', [
            'challenges' => $challenges,
            'trackName' => 'HUMMS',
            'trackFullName' => 'Humanities and Social Sciences',
            'completedChallenges' => $completedChallenges
        ]);
    }

    /**
     * Display the STEM (Science, Technology, Engineering, and Mathematics) track page
     */
    public function stemTrack(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'specialized')
            ->where('tech_category', 'stem')
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

        return view('subjects.specialized-tracks.stem', [
            'challenges' => $challenges,
            'trackName' => 'STEM',
            'trackFullName' => 'Science, Technology, Engineering, and Mathematics',
            'completedChallenges' => $completedChallenges
        ]);
    }

    /**
     * Display the ICT (Information and Communications Technology) track page
     */
    public function ictTrack(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])
            ->where('is_active', true)
            ->where('subject_type', 'specialized')
            ->where('tech_category', 'ict')
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

        return view('subjects.specialized-tracks.ict', [
            'challenges' => $challenges,
            'trackName' => 'ICT',
            'trackFullName' => 'Information and Communications Technology',
            'completedChallenges' => $completedChallenges
        ]);
    }
}
