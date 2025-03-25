<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge; // Import the Challenge model

class CourseController extends Controller
{
    public function index()
    {
        $challenges = Challenge::with('tasks')->where('is_active', true)
            ->orderBy('required_level', 'asc')
            ->get();

        // Calculate total progress based on individual tasks
        $totalTasks = $challenges->sum(function ($challenge) {
            return $challenge->tasks->count();
        });
        $completedTasks = $challenges->sum(function ($challenge) {
            return $challenge->tasks->where('is_completed', true)->count();
        });

        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        $completedLevels = floor($progress / 25); // 4 levels, each representing 25% progress

        return view('courses', compact('challenges'));
    }
}
