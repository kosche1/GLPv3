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

        // Check if the challenge is expired using the model accessor
        if ($challenge->isExpired()) {
            return back()
                ->with('error', 'This challenge has expired and is no longer available.');
        }

        // Check if the user has submitted any answer for this task (not just correct ones)
        $hasSubmission = \App\Models\StudentAnswer::where('user_id', Auth::id())
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

        // Determine if this is a coding task based on challenge category or programming language
        $categoryName = $challenge->category->name ?? '';
        // Updated coding categories - include Computer Programming
        $codingCategories = ['Computer Programming', 'Computer Science', 'Web Development', 'Mobile Development'];
        $isCodingTask = in_array($categoryName, $codingCategories) || !empty($challenge->programming_language);

        // Log the task type determination for debugging
        \Illuminate\Support\Facades\Log::info('Task type determination', [
            'task_id' => $task->id,
            'challenge_id' => $challenge->id,
            'category_name' => $categoryName,
            'programming_language' => $challenge->programming_language ?? 'none',
            'is_coding_task' => $isCodingTask
        ]);

        // Use different views based on task type and subject type
        if ($isCodingTask) {
            return view('challenge.task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
        } else if ($challenge->subject_type === 'core') {
            // Use the core subject specific template for core subjects
            return view('challenge.core-subject-task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
        } else {
            // Use the regular non-coding template for other subjects
            return view('challenge.non-coding-task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
        }
    }

    /**
     * Show a core subject task without checking for previous submissions
     */
    public function showCoreSubjectTask(Challenge $challenge, Task $task)
    {
        if ($task->challenge_id !== $challenge->id) {
            return back()
                ->with('error', 'Task not found in this challenge');
        }

        // Check if the challenge is expired using the model accessor
        if ($challenge->isExpired()) {
            return back()
                ->with('error', 'This challenge has expired and is no longer available.');
        }

        $tasks = $challenge->tasks()->orderBy('order')->get();
        $currentTaskIndex = $tasks->search(function($item) use ($task) {
            return $item->id === $task->id;
        });

        $previousTask = $currentTaskIndex > 0 ? $tasks[$currentTaskIndex - 1] : null;
        $nextTask = $currentTaskIndex < $tasks->count() - 1 ? $tasks[$currentTaskIndex + 1] : null;

        $currentTask = $task;

        // Log the task access for debugging
        \Illuminate\Support\Facades\Log::info('Core subject task access', [
            'task_id' => $task->id,
            'challenge_id' => $challenge->id,
            'subject_type' => $challenge->subject_type
        ]);

        // Always use the core subject template
        return view('challenge.core-subject-task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
    }

    /**
     * Show an applied subject task without checking for previous submissions
     */
    public function showAppliedSubjectTask(Challenge $challenge, Task $task)
    {
        if ($task->challenge_id !== $challenge->id) {
            return back()
                ->with('error', 'Task not found in this challenge');
        }

        // Check if the challenge is expired using the model accessor
        if ($challenge->isExpired()) {
            return back()
                ->with('error', 'This challenge has expired and is no longer available.');
        }

        $tasks = $challenge->tasks()->orderBy('order')->get();
        $currentTaskIndex = $tasks->search(function($item) use ($task) {
            return $item->id === $task->id;
        });

        $previousTask = $currentTaskIndex > 0 ? $tasks[$currentTaskIndex - 1] : null;
        $nextTask = $currentTaskIndex < $tasks->count() - 1 ? $tasks[$currentTaskIndex + 1] : null;

        $currentTask = $task;

        // Log the task access for debugging
        \Illuminate\Support\Facades\Log::info('Applied subject task access', [
            'task_id' => $task->id,
            'challenge_id' => $challenge->id,
            'subject_type' => $challenge->subject_type
        ]);

        // Use the core subject template for applied subjects as well
        return view('challenge.core-subject-task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
    }

    /**
     * Show a specialized subject task without checking for previous submissions
     */
    public function showSpecializedSubjectTask(Challenge $challenge, Task $task)
    {
        if ($task->challenge_id !== $challenge->id) {
            return back()
                ->with('error', 'Task not found in this challenge');
        }

        // Check if the challenge is expired
        $now = now();
        if ($challenge->end_date && $now->gt($challenge->end_date)) {
            return back()
                ->with('error', 'This challenge has expired and is no longer available.');
        }

        $tasks = $challenge->tasks()->orderBy('order')->get();
        $currentTaskIndex = $tasks->search(function($item) use ($task) {
            return $item->id === $task->id;
        });

        $previousTask = $currentTaskIndex > 0 ? $tasks[$currentTaskIndex - 1] : null;
        $nextTask = $currentTaskIndex < $tasks->count() - 1 ? $tasks[$currentTaskIndex + 1] : null;

        $currentTask = $task;

        // Log the task access for debugging
        \Illuminate\Support\Facades\Log::info('Specialized subject task access', [
            'task_id' => $task->id,
            'challenge_id' => $challenge->id,
            'subject_type' => $challenge->subject_type,
            'tech_category' => $challenge->tech_category
        ]);

        // For ICT specialized subjects, use the task.blade.php template to enable code editor
        if ($challenge->tech_category === 'ict') {
            // Force programming_language to be set if it's not already
            if (empty($challenge->programming_language)) {
                $challenge->programming_language = 'python'; // Default to Python if not specified
            }

            // Ensure challenge_content has required fields for code editor
            if (empty($challenge->challenge_content)) {
                $challenge->challenge_content = [
                    'scenario' => $currentTask->description,
                    'buggy_code' => '# Write your code here',
                    'current_behavior' => 'No code available',
                    'expected_behavior' => $currentTask->description
                ];
            }

            // If it's an ICT subject, use the task.blade.php template
            return view('challenge.task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
        }

        // For other specialized subjects, use the core subject template
        return view('challenge.core-subject-task', compact('challenge', 'currentTask', 'previousTask', 'nextTask'));
    }
}