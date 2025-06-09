<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only update for authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update the last_activity_at timestamp
            $user->update([
                'last_activity_at' => now()
            ]);
        }

        return $response;
    }
}
