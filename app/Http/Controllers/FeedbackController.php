<?php

namespace App\Http\Controllers;

use App\Models\StudentAnswer;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(): View
    {
        // Get all feedback for the current user, excluding exact match evaluations
        $feedbackItems = StudentAnswer::where('student_answers.user_id', Auth::id())
            ->whereNotNull('student_answers.feedback')
            ->where('student_answers.feedback', '!=', '')
            ->join('tasks', 'student_answers.task_id', '=', 'tasks.id')
            ->where(function($query) {
                $query->where('tasks.evaluation_type', '!=', 'exact_match')
                      ->orWhereNull('tasks.evaluation_type');
            })
            ->select('student_answers.*')
            ->with(['task', 'task.challenge', 'evaluator'])
            ->orderBy('student_answers.evaluated_at', 'desc')
            ->get();

        // Group feedback by challenge
        $feedbackByChallenge = [];
        foreach ($feedbackItems as $item) {
            if ($item->task && $item->task->challenge) {
                $challengeId = $item->task->challenge->id;
                $challengeName = $item->task->challenge->name;

                if (!isset($feedbackByChallenge[$challengeId])) {
                    $feedbackByChallenge[$challengeId] = [
                        'challenge_name' => $challengeName,
                        'challenge_id' => $challengeId,
                        'items' => []
                    ];
                }

                $feedbackByChallenge[$challengeId]['items'][] = [
                    'task_name' => $item->task->name,
                    'task_id' => $item->task->id,
                    'feedback' => $item->feedback,
                    'is_correct' => $item->is_correct,
                    'score' => $item->score,
                    'evaluated_at' => $item->evaluated_at,
                    'evaluator_name' => $item->evaluator ? $item->evaluator->name : 'System'
                ];
            }
        }

        return view('feedback', [
            'feedbackByChallenge' => $feedbackByChallenge
        ]);
    }
}