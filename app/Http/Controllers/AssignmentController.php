<?php

namespace App\Http\Controllers;

use App\Models\Task;

use App\Models\StudentAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    /**
     * Display a listing of tasks and challenges for the user.
     */
    public function index(): View
    {
        // Get all active tasks with their challenges, paginated
        $tasks = Task::with('challenge')
            ->whereHas('challenge', function($query) {
                $query->where('is_active', true);
            })
            ->orderBy('challenge_id')
            ->orderBy('order')
            ->paginate(12); // Show 12 tasks per page

        // Get the user's completed tasks
        $completedTaskIds = StudentAnswer::where('user_id', Auth::id())
            ->where('is_correct', true)
            ->pluck('task_id')
            ->toArray();

        // Get the user's in-progress tasks (submitted but not correct)
        $inProgressTaskIds = StudentAnswer::where('user_id', Auth::id())
            ->where(function($query) {
                $query->where('is_correct', false)
                      ->orWhereNull('is_correct');
            })
            ->pluck('task_id')
            ->toArray();

        // Return the view with the data
        return view('assignments', [
            'tasks' => $tasks,
            'completedTaskIds' => $completedTaskIds,
            'inProgressTaskIds' => $inProgressTaskIds
        ]);
    }
}