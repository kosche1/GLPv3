<?php

namespace App\Listeners;

use App\Events\ChallengeCompleted;
use App\Models\AuditTrail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RecordChallengeCompletion implements ShouldQueue
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
    public function handle(ChallengeCompleted $event): void
    {
        try {
            // Record the challenge completion in the audit trail
            AuditTrail::recordChallengeCompletion(
                $event->user,
                $event->challenge,
                [
                    'progress' => 100,
                    'completed_at' => now()->toDateTimeString(),
                ]
            );
            
            Log::info('Challenge completion recorded in audit trail', [
                'user_id' => $event->user->id,
                'challenge_id' => $event->challenge->id,
                'challenge_name' => $event->challenge->name,
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording challenge completion in audit trail: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
