<?php

namespace App\Livewire\Actions;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        // Get the current user before logging out
        $user = Auth::user();

        if ($user) {
            try {
                // Create a unique key for this logout session that will last for the entire day
                $logoutKey = 'logout_recorded_' . date('Y-m-d') . '_' . $user->id;

                // Check if we've already recorded a logout for this user today
                if (Session::has($logoutKey)) {
                    Log::info('Logout already recorded for this user today, skipping', [
                        'user_id' => $user->id,
                        'logout_key' => $logoutKey
                    ]);
                } else {
                    // Check if there's already a logout record for this user today in the database
                    $today = now()->startOfDay();
                    $existingLogout = AuditTrail::where('user_id', $user->id)
                        ->where('action_type', 'logout')
                        ->whereDate('created_at', $today)
                        ->first();

                    if ($existingLogout) {
                        Log::info('Logout already recorded in database for today, skipping', [
                            'user_id' => $user->id,
                            'existing_audit_trail_id' => $existingLogout->id
                        ]);
                    } else {
                        // Record the logout event in the audit trail
                        Log::info('Recording logout in audit trail', [
                            'user_id' => $user->id,
                            'user_name' => $user->name
                        ]);

                        AuditTrail::recordLogout($user);

                        // Mark as recorded in the session
                        Session::put($logoutKey, true);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error recording logout in audit trail', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        // Clear session lock state is handled by JavaScript in the login page

        return redirect('/');
    }
}
