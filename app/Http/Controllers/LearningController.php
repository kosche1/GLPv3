<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAnswer;
use App\Models\Category;

class LearningController extends Controller
{
    public function index(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])->where('is_active', true)
            ->orderBy('required_level', 'asc')
            ->get();

        $techCategories = Category::all()->pluck('name', 'id');
        $totalTasks = $challenges->sum(function ($challenge) {
            return $challenge->tasks->count();
        });
        $completedTasks = $challenges->sum(function ($challenge) {
            return $challenge->tasks->where('is_completed', true)->count();
        });

        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        $completedLevels = floor($progress / 25); // 4 levels, each representing 25% progress

        return view('learning', [
            'challenges' => $challenges,
            'progress' => $progress,
            'completedLevels' => $completedLevels,
            'techCategories' => $techCategories
        ]);
    }

    public function show(Challenge $challenge): View
    {
        // Get all tasks for this challenge
        $tasks = $challenge->tasks()->orderBy('order')->get();
        
        // Check which tasks are completed by the current user
        $completedTaskIds = [];
        if (Auth::check()) {
            $completedTaskIds = StudentAnswer::where('user_id', Auth::id())
                ->where('is_correct', true)
                ->whereIn('task_id', $tasks->pluck('id'))
                ->pluck('task_id')
                ->toArray();
        }
        
        return view('challenge', [
            'challenge' => $challenge,
            'tasks' => $tasks,
            'completedTaskIds' => $completedTaskIds
        ]);
    }

    public function showTask(Challenge $challenge, string $task): View
    {
        $currentTask = $challenge->tasks()->findOrFail($task);
        $nextTask = $challenge->tasks()
            ->where('id', '>', $task)
            ->orderBy('id')
            ->first()?->id;

        return view('challenge.task', [
            'challenge' => $challenge,
            'currentTask' => $currentTask,
            'nextTask' => $nextTask
        ]);
    }
}