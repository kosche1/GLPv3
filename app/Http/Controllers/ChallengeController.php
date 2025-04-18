<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function show(Challenge $challenge)
    {
        return view('challenge.index', compact('challenge'));
    }

    public function showTask(Challenge $challenge, Task $task)
    {
        if ($task->challenge_id !== $challenge->id) {
            return back()
                ->with('error', 'Task not found in this challenge');
        }

        // Check if the user has submitted any answer for this task (not just correct ones)
        $hasSubmission = Auth::user()->studentAnswers()
            ->where('task_id', $task->id)
            ->exists();

        if ($hasSubmission) {
            return back()
                ->with('message', 'You have already submitted an answer for this task!');
        }

        $tasks = $challenge->tasks()->orderBy('order')->get();
        $currentTaskIndex = $tasks->search(function($item) use ($task) {
            return $item->id === $task->id;
        });

        $previousTask = $currentTaskIndex > 0 ? $tasks[$currentTaskIndex - 1] : null;
        $nextTask = $currentTaskIndex < $tasks->count() - 1 ? $tasks[$currentTaskIndex + 1] : null;

        $currentTask = $task;

        return view('challenge.task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
    }
}