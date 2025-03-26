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
            // Check if the task has already been completed by this user
            $isCompleted = StudentAnswer::where('user_id', Auth::id())
                ->where('task_id', $task->id)
                ->where('is_correct', true)
                ->exists();
                
            if ($isCompleted) {
                // Redirect to the challenge page with a message
                return redirect()->route('challenge', $task->challenge_id)
                    ->with('message', 'You have already completed this task!');
            }
        }
        
        return $next($request);
    }
} 