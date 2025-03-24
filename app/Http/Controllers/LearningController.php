<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\View\View;

class LearningController extends Controller
{
    public function index(): View
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

        return view('learning', [
            'challenges' => $challenges,
            'progress' => $progress,
            'completedLevels' => $completedLevels
        ]);
    }

    public function show(string $id): View
    {
        $challenge = Challenge::findOrFail($id);
        $nextTask = $challenge->tasks()->first()?->id ?? null;

        return view('challenge', [
            'challenge' => $challenge,
            'nextTask' => $nextTask
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