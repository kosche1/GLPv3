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
        // Always log when middleware is called
        Log::info('TrackAttendance middleware: Called', [
            'path' => $request->path(),
            'method' => $request->method(),
            'authenticated' => Auth::check() ? 'yes' : 'no'
        ]);

        if (Auth::check()) {
            try {
                $userId = Auth::id();
                Log::info('TrackAttendance middleware: Recording attendance for user ' . $userId);
                $result = StudentAttendance::recordDailyAttendance($userId);
                Log::info('TrackAttendance middleware: Result', [
                    'result' => $result ? 'success' : 'failed',
                    'record_id' => $result ? $result->id : null,
                    'login_count' => $result ? $result->login_count : null
                ]);
            } catch (\Exception $e) {
                Log::error('TrackAttendance middleware error: ' . $e->getMessage());
                Log::error($e->getTraceAsString());
            }
        } else {
            Log::info('TrackAttendance middleware: User not authenticated');
        }

        return $next($request);
    }
}