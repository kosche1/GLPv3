<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Services\RealTimeService;

class UpdateUserActivity
{
    protected $realTimeService;

    public function __construct(RealTimeService $realTimeService)
    {
        $this->realTimeService = $realTimeService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Update user's last activity timestamp if authenticated
        if (Auth::check()) {
            try {
                $user = Auth::user();

                // Check if user was offline before updating
                $wasOffline = !$user->last_activity_at ||
                             $user->last_activity_at->diffInMinutes(now()) > 5;

                // Update the last activity timestamp directly in the database
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['last_activity_at' => now()]);

                // Refresh the user model to get the updated timestamp
                $user->refresh();

                // If user was offline and is now online, broadcast status update
                if ($wasOffline) {
                    try {
                        $this->realTimeService->broadcastUserOnlineStatus($user, 'online');
                    } catch (\Exception $e) {
                        // Log error but don't break the request
                        Log::error('Failed to broadcast user online status: ' . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                // Log error but don't break the request
                Log::error('Failed to update user activity: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
