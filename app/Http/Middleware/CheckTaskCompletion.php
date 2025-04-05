<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAnswer;
use Symfony\Component\HttpFoundation\Response;

class CheckTaskCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $task = $request->route('task');

        if ($task && Auth::check()) {
            // Check if the task has already been submitted by this user (any submission, not just correct ones)
            $hasSubmission = StudentAnswer::where('user_id', Auth::id())
                ->where('task_id', $task->id)
                ->exists();

            if ($hasSubmission) {
                // Redirect to the challenge page with a message
                return redirect()->route('challenge', $task->challenge_id)
                    ->with('message', 'You have already submitted an answer for this task!');
            }
        }

        return $next($request);
    }
}