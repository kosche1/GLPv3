<?php

namespace App\Observers;

use App\Models\StudentAnswer;
use App\Services\AnswerEvaluationService;
use Illuminate\Support\Facades\Log;

class StudentAnswerObserver
{
    /**
     * @var AnswerEvaluationService
     */
    protected $evaluationService;

    public function __construct(AnswerEvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
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
        if ($studentAnswer->isDirty('is_correct') && $studentAnswer->is_correct &&
            $studentAnswer->status === 'evaluated') {

            Log::info("StudentAnswer ID: {$studentAnswer->id} marked as correct through manual evaluation.");

            // Note: We're not awarding points here because it's handled in the EditStudentAnswer page
            // This is just for logging purposes
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
