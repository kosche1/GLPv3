<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Challenge;
use App\Models\Category;
use App\Models\Strand;
use App\Models\SubjectType;

class SubjectsController extends Controller
{
    /**
     * Display the Core Subjects page
     */
    public function coreSubjects(): View
    {
        // Get the Core subject type
        $subjectType = SubjectType::where('code', 'core')->first();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
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
        // Get the Applied subject type
        $subjectType = SubjectType::where('code', 'applied')->first();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
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
        // Get the Specialized subject type
        $subjectType = SubjectType::where('code', 'specialized')->first();

        // Get all strands for the specialized subjects page
        $strands = Strand::where('is_active', true)->orderBy('order')->get();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
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
            'completedChallenges' => $completedChallenges,
            'strands' => $strands
        ]);
    }

    /**
     * Display the ABM (Accountancy, Business, and Management) track page
     */
    public function abmTrack(): View
    {
        // Get the Specialized subject type
        $subjectType = SubjectType::where('code', 'specialized')->first();

        // Get the ABM strand
        $strand = Strand::where('code', 'abm')->first();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
            ->where('strand_id', $strand?->id)
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
        // Get the Specialized subject type
        $subjectType = SubjectType::where('code', 'specialized')->first();

        // Get the HE strand
        $strand = Strand::where('code', 'he')->first();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
            ->where('strand_id', $strand?->id)
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
        // Get the Specialized subject type
        $subjectType = SubjectType::where('code', 'specialized')->first();

        // Get the HUMMS strand
        $strand = Strand::where('code', 'humms')->first();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
            ->where('strand_id', $strand?->id)
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
        // Get the Specialized subject type
        $subjectType = SubjectType::where('code', 'specialized')->first();

        // Get the STEM strand
        $strand = Strand::where('code', 'stem')->first();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
            ->where('strand_id', $strand?->id)
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
        // Get the Specialized subject type
        $subjectType = SubjectType::where('code', 'specialized')->first();

        // Get the ICT strand
        $strand = Strand::where('code', 'ict')->first();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
            ->where('strand_id', $strand?->id)
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

    /**
     * Display subjects for any subject type by code
     */
    public function showSubjectType(string $code): View
    {
        // Get the subject type by code
        $subjectType = SubjectType::where('code', $code)->firstOrFail();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType->id)
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

        // Check if there's a specific view for this subject type
        $viewName = 'subjects.generic-subjects';

        // Try to find a specific view for this subject type
        $specificViewName = 'subjects.' . $code . '-subjects';
        if (view()->exists($specificViewName)) {
            $viewName = $specificViewName;
        }

        return view($viewName, [
            'challenges' => $challenges,
            'subjectType' => $subjectType->name,
            'subjectTypeObject' => $subjectType,
            'completedChallenges' => $completedChallenges
        ]);
    }

    /**
     * Display subjects for any strand by code
     */
    public function showStrand(string $code): View
    {
        // Get the Specialized subject type
        $subjectType = SubjectType::where('code', 'specialized')->first();

        // Get the strand by code
        $strand = Strand::where('code', $code)->firstOrFail();

        $challenges = Challenge::with(['tasks', 'category', 'strand', 'subjectType'])
            ->where('is_active', true)
            ->where('subject_type_id', $subjectType?->id)
            ->where('strand_id', $strand->id)
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

        // Check if there's a specific view for this strand
        $viewName = 'subjects.specialized-tracks.generic';

        // Try to find a specific view for this strand
        $specificViewName = 'subjects.specialized-tracks.' . $code;
        if (view()->exists($specificViewName)) {
            $viewName = $specificViewName;
        }

        return view($viewName, [
            'challenges' => $challenges,
            'trackName' => $strand->name,
            'trackFullName' => $strand->full_name,
            'strand' => $strand,
            'completedChallenges' => $completedChallenges
        ]);
    }
}
