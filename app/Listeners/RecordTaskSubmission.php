<?php

namespace App\Listeners;

use App\Events\TaskSubmitted;
use App\Models\AuditTrail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RecordTaskSubmission implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskSubmitted $event): void
    {
        try {
            // Record the task submission in the audit trail
            AuditTrail::recordTaskSubmission(
                $event->user,
                $event->task,
                $event->answer,
                [
                    'submitted_at' => now()->toDateTimeString(),
                ]
            );
            
            Log::info('Task submission recorded in audit trail', [
                'user_id' => $event->user->id,
                'task_id' => $event->task->id,
                'task_name' => $event->task->name,
                'answer_id' => $event->answer->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording task submission in audit trail: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
