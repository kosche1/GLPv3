<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrackAttendance
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            try {
                $userId = Auth::id();
                Log::info('TrackAttendance middleware: Recording attendance for user ' . $userId);
                $result = StudentAttendance::recordDailyAttendance($userId);
                Log::info('TrackAttendance middleware: Result', ['result' => $result ? 'success' : 'failed']);
            } catch (\Exception $e) {
                Log::error('TrackAttendance middleware error: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}