<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAnswer;
use App\Models\Category;
use App\Models\SubjectType;

class LearningController extends Controller
{
    /**
     * Get the user's level or default to 1 if the method doesn't exist
     */
    private function getUserLevel(): int
    {
        if (!Auth::check()) {
            return 1;
        }

        $user = Auth::user();
        return method_exists($user, 'getLevel') ? $user->getLevel() : 1;
    }
    public function index(): View
    {
        $challenges = Challenge::with(['tasks', 'category'])->where('is_active', true)
            ->orderBy('required_level', 'asc')
            ->get();

        $techCategories = Category::all()->pluck('name', 'id');

        // Fetch active subject types ordered by their order field
        $subjectTypes = SubjectType::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Calculate overall progress
        $totalTasks = $challenges->sum(function ($challenge) {
            return $challenge->tasks->count();
        });

        $completedTasks = 0;
        $completedChallenges = [];
        $lockedChallenges = [];
        $challengeFeedback = [];

        // Check which challenges are completed by the current user
        if (Auth::check()) {
            $userLevel = $this->getUserLevel();

            foreach ($challenges as $challenge) {
                // Check if challenge is locked due to level requirement
                if ($challenge->required_level > $userLevel) {
                    $lockedChallenges[] = $challenge->id;
                }
                $challengeTasks = $challenge->tasks;
                $totalChallengeTasks = $challengeTasks->count();

                if ($totalChallengeTasks > 0) {
                    // Count completed tasks for this challenge
                    $completedChallengeTasks = 0;
                    $feedbackForChallenge = [];

                    foreach ($challengeTasks as $task) {
                        // Check if the task has a submission or is completed
                        $studentAnswer = StudentAnswer::where('user_id', Auth::id())
                            ->where('task_id', $task->id)
                            ->first();

                        $hasSubmission = $studentAnswer !== null;

                        if ($task->completed || $hasSubmission) {
                            $completedChallengeTasks++;
                            $completedTasks++;

                            // Check if there's feedback for this task
                            if ($hasSubmission && !empty($studentAnswer->feedback)) {
                                $feedbackForChallenge[] = [
                                    'task_name' => $task->name,
                                    'feedback' => $studentAnswer->feedback,
                                    'is_correct' => $studentAnswer->is_correct,
                                    'score' => $studentAnswer->score,
                                ];
                            }
                        }
                    }

                    // If all tasks in the challenge are completed, mark the challenge as completed
                    if ($completedChallengeTasks >= $totalChallengeTasks) {
                        $completedChallenges[] = $challenge->id;

                        // If there's feedback for this challenge, store it
                        if (!empty($feedbackForChallenge)) {
                            $challengeFeedback[$challenge->id] = $feedbackForChallenge;
                        }
                    }
                }
            }
        }

        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        $completedLevels = floor($progress / 25); // 4 levels, each representing 25% progress

        return view('learning', [
            'challenges' => $challenges,
            'progress' => $progress,
            'completedLevels' => $completedLevels,
            'techCategories' => $techCategories,
            'completedChallenges' => $completedChallenges,
            'lockedChallenges' => $lockedChallenges,
            'challengeFeedback' => $challengeFeedback,
            'subjectTypes' => $subjectTypes
        ]);
    }

    public function show(Challenge $challenge)
    {
        // Check if the challenge is expired using the model accessor
        $isExpired = $challenge->isExpired();

        // Check if the user has the required level to access this challenge
        $userLevel = $this->getUserLevel();
        $isLocked = false;

        // Check if the challenge requires a higher level than the user has
        if ($challenge->required_level > $userLevel) {
            $isLocked = true;
        }

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
            'completedTaskIds' => $completedTaskIds,
            'isExpired' => $isExpired,
            'isLocked' => $isLocked,
            'userLevel' => $userLevel
        ]);
    }

    public function showTask(Challenge $challenge, string $task)
    {
        // Check if the user has the required level to access this challenge
        $userLevel = $this->getUserLevel();

        // If the challenge requires a higher level than the user has, redirect to the challenge page
        if ($challenge->required_level > $userLevel) {
            return redirect()->route('challenge', ['challenge' => $challenge])
                ->with('error', 'You need to reach level ' . $challenge->required_level . ' to access the tasks in this challenge.');
        }

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