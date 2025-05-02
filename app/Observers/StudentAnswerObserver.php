<?php

namespace App\Observers;

use App\Models\StudentAnswer;
use App\Services\AnswerEvaluationService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class StudentAnswerObserver
{
    /**
     * @var AnswerEvaluationService
     */
    protected $evaluationService;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    public function __construct(AnswerEvaluationService $evaluationService, NotificationService $notificationService)
    {
        $this->evaluationService = $evaluationService;
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the StudentAnswer "created" event.
     */
    public function created(StudentAnswer $studentAnswer): void
    {
        // Check if created with 'submitted' status
        if ($studentAnswer->status === 'submitted') {
            Log::info("StudentAnswer ID: {$studentAnswer->id} created with status 'submitted'. Triggering evaluation.");
            $this->evaluationService->evaluate($studentAnswer);
        }
    }

    /**
     * Handle the StudentAnswer "updated" event.
     */
    public function updated(StudentAnswer $studentAnswer): void
    {
        // Check if the status was changed to 'submitted'
        if ($studentAnswer->isDirty('status') && $studentAnswer->status === 'submitted') {
            Log::info("StudentAnswer ID: {$studentAnswer->id} updated to status 'submitted'. Triggering evaluation.");
            $this->evaluationService->evaluate($studentAnswer);
        }

        // Check if the answer was marked as correct through manual evaluation
        if (($studentAnswer->isDirty('is_correct') || $studentAnswer->isDirty('status')) &&
            $studentAnswer->is_correct && $studentAnswer->status === 'evaluated') {

            Log::info("StudentAnswer ID: {$studentAnswer->id} marked as correct through manual evaluation.", [
                'is_correct' => $studentAnswer->is_correct,
                'status' => $studentAnswer->status,
                'evaluated_at' => $studentAnswer->evaluated_at
            ]);

            // Note: We're not awarding points here because it's handled in the EditStudentAnswer page
            // This is just for logging purposes

            // Make sure notification_shown is set to false to trigger the modal
            $studentAnswer->notification_shown = false;
            $studentAnswer->saveQuietly(); // Save without triggering observers again

            // Create a notification for the student
            try {
                $user = $studentAnswer->user;
                $task = $studentAnswer->task;

                if ($user && $task) {
                    // Create a task approval notification
                    $notification = $this->notificationService->createNotification(
                        $user,
                        "Your answer for '{$task->name}' has been approved! You've earned {$task->points_reward} points.",
                        'grade',
                        route('challenge.task', ['challenge' => $task->challenge_id, 'task' => $task->id])
                    );

                    Log::info('Task approval notification created', [
                        'notification_id' => $notification->id,
                        'user_id' => $user->id,
                        'task_id' => $task->id,
                        'points' => $task->points_reward,
                        'student_answer_id' => $studentAnswer->id
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error creating task approval notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'student_answer_id' => $studentAnswer->id
                ]);
            }
        }
    }

    /**
     * Handle the StudentAnswer "deleted" event.
     */
    public function deleted(StudentAnswer $studentAnswer): void
    {
        //
    }

    /**
     * Handle the StudentAnswer "restored" event.
     */
    public function restored(StudentAnswer $studentAnswer): void
    {
        //
    }

    /**
     * Handle the StudentAnswer "force deleted" event.
     */
    public function forceDeleted(StudentAnswer $studentAnswer): void
    {
        //
    }
}
