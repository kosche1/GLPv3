<?php

namespace App\Listeners;

use App\Models\AuditTrail;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RecordUserLogin
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
    public function handle(Login $event): void
    {
        try {
            Log::info('RecordUserLogin listener triggered');

            $user = $event->user;

            // Create a unique key for this login session that will last for the entire day
            // This prevents multiple login records for the same user on the same day
            $loginKey = 'login_recorded_' . date('Y-m-d') . '_' . $user->id;

            // Check if we've already recorded a login for this user today
            if (Session::has($loginKey)) {
                Log::info('Login already recorded for this user today, skipping', [
                    'user_id' => $user->id,
                    'login_key' => $loginKey
                ]);
                return;
            }

            Log::info('User retrieved from login event', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email
            ]);

            // Check if there's already a login record for this user today in the database
            $today = now()->startOfDay();
            $existingLogin = AuditTrail::where('user_id', $user->id)
                ->where('action_type', 'login')
                ->whereDate('created_at', $today)
                ->first();

            if ($existingLogin) {
                Log::info('Login already recorded in database for today, skipping', [
                    'user_id' => $user->id,
                    'existing_audit_trail_id' => $existingLogin->id
                ]);

                // Mark as recorded in the session to prevent future attempts
                Session::put($loginKey, true);
                return;
            }

            try {
                // Record login in audit trail
                $result = AuditTrail::recordLogin($user);

                // Mark as recorded in the session
                Session::put($loginKey, true);

                Log::info('Login recorded in audit trail', [
                    'user_id' => $user->id,
                    'audit_trail_id' => $result->id,
                    'timestamp' => now()->toDateTimeString()
                ]);
            } catch (\Exception $e) {
                Log::error('Error recording login in audit trail: ' . $e->getMessage(), [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in RecordUserLogin listener: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
