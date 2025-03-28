<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    /**
     * Display a listing of tasks and challenges for the user.
     */
    public function index(): View
    {
        // Get all active challenges with their tasks
        $challenges = Challenge::with('tasks')
            ->where('is_active', true)
            ->orderBy('required_level', 'asc')
            ->get();
            
        // Get user's tasks from the user_tasks pivot table
        $userTasks = Auth::user()->tasks()
            ->with('challenge')
            ->get();
        
        // Return the view with the data
        return view('assignments', [
            'challenges' => $challenges,
            'challengeTasks' => $userTasks
        ]);
    }
} 