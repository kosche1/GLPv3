<?php

namespace App\Listeners;

use App\Models\StudentAttendance;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RecordUserAttendance
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
            $user = $event->user;

            // Check if we've already recorded attendance for this session
            $sessionKey = 'attendance_recorded_' . date('Y-m-d') . '_' . $user->id;
            if (Session::has($sessionKey)) {
                Log::info('Attendance already recorded for this session', [
                    'user_id' => $user->id,
                    'session_key' => $sessionKey
                ]);
                return;
            }

            Log::info('Login event detected for user: ' . $user->id, [
                'event_class' => get_class($event),
                'guard' => $event->guard ?? 'unknown'
            ]);

            try {
                // Record attendance
                $result = StudentAttendance::recordDailyAttendance($user->id);

                // Mark as recorded in the session
                Session::put($sessionKey, true);

                Log::info('Attendance recorded via login event', [
                    'user_id' => $user->id,
                    'record_id' => $result ? $result->id : null,
                    'login_count' => $result ? $result->login_count : null
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                // If it's a duplicate key error, it means attendance was already recorded
                if (str_contains($e->getMessage(), 'Duplicate entry') || str_contains($e->getMessage(), 'UNIQUE constraint failed')) {
                    Log::info('Attendance already recorded in database', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage()
                    ]);

                    // Mark as recorded in the session anyway
                    Session::put($sessionKey, true);
                } else {
                    // For other database errors, log and rethrow
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            Log::error('Error recording attendance in login event listener: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
