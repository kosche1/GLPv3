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

        return view('subjects.core-subjects', [
            'challenges' => $challenges,
            'subjectType' => 'Core'
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

        return view('subjects.applied-subjects', [
            'challenges' => $challenges,
            'subjectType' => 'Applied'
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

        return view('subjects.specialized-subjects', [
            'challenges' => $challenges,
            'subjectType' => 'Specialized'
        ]);
    }
}
