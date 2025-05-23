<?php

namespace App\Http\Middleware;

use App\Models\AuditTrail;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LogFilamentLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if this is a logout request from Filament
        if ($request->isMethod('post') && 
            (str_contains($request->path(), 'logout') || 
             str_contains($request->path(), 'admin/logout') || 
             str_contains($request->path(), 'teacher/logout'))) {
            
            // Get the current user before they're logged out
            $user = Auth::user();
            
            if ($user) {
                Log::info('Filament logout detected', [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'path' => $request->path()
                ]);
                
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
                            Log::info('Recording logout in audit trail from middleware', [
                                'user_id' => $user->id,
                                'user_name' => $user->name
                            ]);
                            
                            AuditTrail::recordLogout($user);
                            
                            // Mark as recorded in the session
                            Session::put($logoutKey, true);
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error recording logout in audit trail middleware', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        }
        
        return $next($request);
    }
}
