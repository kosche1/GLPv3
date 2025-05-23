<?php

namespace App\Listeners;

use App\Models\AuditTrail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class RecordUserRegistration
{

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
    public function handle(Registered $event): void
    {
        try {
            // Check if an audit trail entry already exists for this user's registration
            $existingEntry = AuditTrail::where('user_id', $event->user->id)
                ->where('action_type', 'registration')
                ->exists();

            if ($existingEntry) {
                Log::info('Audit trail entry for registration already exists, skipping creation', [
                    'user_id' => $event->user->id,
                    'name' => $event->user->name,
                    'email' => $event->user->email,
                ]);
                return;
            }

            // Record the registration in the audit trail
            $auditTrail = AuditTrail::recordRegistration($event->user);

            Log::info('User registration recorded in audit trail', [
                'user_id' => $event->user->id,
                'name' => $event->user->name,
                'email' => $event->user->email,
                'audit_trail_id' => $auditTrail->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording user registration in audit trail: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
