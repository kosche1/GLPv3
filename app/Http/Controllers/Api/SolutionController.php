<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentAnswer;
use App\Models\User;
use App\Models\Task;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SolutionController extends Controller
{
    public function submit(Request $request)
    {
        try {
            // Log the incoming request data for debugging
            Log::info('Solution submission request data:', [
                'request_data' => $request->all()
            ]);
            
            // Check if user is authenticated
            $userId = Auth::check() ? Auth::id() : null;

            // If no user ID is available, use a fallback for testing
            if (!$userId) {
                // Get the first user from the database or use a fixed ID
                $userId = \App\Models\User::first()->id ?? 1;
                Log::warning('Using fallback user ID: ' . $userId);
            }
            
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'student_answer' => 'required|array',
                'student_answer.code' => 'required|string|max:10000',
                'student_answer.output' => 'nullable|string'
            ]);

            // Get the code and output from the request
            $code = $validated['student_answer']['code'];
            $output = $validated['student_answer']['output'] ?? '';
            
            // Get the task and challenge
            $task = Task::with('challenge')->find($validated['task_id']);
            
            if (!$task) {
                Log::error('Task not found:', ['task_id' => $validated['task_id']]);
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found'
                ], 404);
            }
            
            $challenge = $task->challenge;
            
            if (!$challenge) {
                Log::error('Challenge not found for task:', ['task_id' => $validated['task_id']]);
                $language = 'python'; // Default fallback
            } else {
                $language = $challenge->programming_language ?? 'python';
            }
            
            // Check if the task has already been completed by this user
            $existingCorrectAnswer = StudentAnswer::where('user_id', $userId)
                ->where('task_id', $task->id)
                ->where('is_correct', true)
                ->exists();
                
            if ($existingCorrectAnswer) {
                return response()->json([
                    'success' => true,
                    'is_correct' => true,
                    'already_completed' => true,
                    'message' => 'You have already completed this task!',
                    'redirect' => route('challenge', $challenge->id),
                    'with_message' => true
                ]);
            }
            
            // Create data array based on available columns
            $data = [
                'user_id' => $userId,
                'task_id' => $task->id,
                'solution' => $code,
                'output' => $output,
                'status' => 'submitted',
                'student_answer' => [
                    'code' => $code,
                    'language' => $language,
                    'output' => $output
                ]
            ];
            
            // Create the student answer record
            $studentAnswer = new StudentAnswer($data);
            
            // Check if the answer is correct
            $isCorrect = false;
            try {
                // Get the task's answer key
                $answerKey = $task->answer_key;
                
                // Log the answer key for debugging
                Log::info('Checking answer with key:', [
                    'answer_key' => $answerKey,
                    'output' => $output,
                    'task_id' => $task->id
                ]);
                
                // If there's an answer key, compare with the output
                if (!empty($answerKey) && !empty($output)) {
                    // Normalize both strings for comparison
                    $normalizedOutput = trim(strtolower($output));
                    $normalizedAnswerKey = trim(strtolower($answerKey));
                    
                    // Check for exact match first
                    $isCorrect = $normalizedOutput === $normalizedAnswerKey;
                    
                    // If not exact match, check if the answer key is contained within the output
                    if (!$isCorrect) {
                        // Convert both to strings and remove all whitespace for more flexible comparison
                        $strippedOutput = preg_replace('/\s+/', '', $normalizedOutput);
                        $strippedAnswerKey = preg_replace('/\s+/', '', $normalizedAnswerKey);
                        
                        // Check if the stripped answer key is in the stripped output
                        $isCorrect = strpos($strippedOutput, $strippedAnswerKey) !== false;
                        
                        // If still not correct, try comparing just the numeric values
                        if (!$isCorrect && is_numeric(trim($answerKey))) {
                            // Extract numbers from output
                            preg_match('/\d+/', $normalizedOutput, $matches);
                            if (!empty($matches) && $matches[0] == trim($answerKey)) {
                                $isCorrect = true;
                            }
                        }
                    }
                    
                    // Log comparison details for debugging
                    Log::info('Answer comparison:', [
                        'normalized_output' => $normalizedOutput,
                        'normalized_answer_key' => $normalizedAnswerKey,
                        'is_correct' => $isCorrect
                    ]);
                    
                    // Log the result of the comparison
                    Log::info('Answer comparison result:', [
                        'is_correct' => $isCorrect,
                        'method' => 'direct comparison'
                    ]);
                    
                    // If incorrect, prepare error message for execution output
                    if (!$isCorrect) {
                        // Append error message to the output
                        $output .= "\n\n❌ Your solution output doesn't match the expected result. Please try again.";
                    } else {
                        // Append success message to the output
                        $output .= "\n\n✅ Solution and Results are Correct. Redirecting to Challenge Page...";
                    }
                    $data['output'] = $output; // Update the output in the data array
                } else {
                    // Fall back to the task's checkAnswer method for other types of tasks
                    $isCorrect = $task->checkAnswer([
                        'code' => $code,
                        'output' => $output,
                        'language' => $language
                    ]);
                    
                    // Log the result of the task's checkAnswer method
                    Log::info('Task checkAnswer result:', [
                        'is_correct' => $isCorrect,
                        'method' => 'task checkAnswer'
                    ]);
                    
                    // If correct, append success message
                    if (!$isCorrect) {
                        Log::info('Solution is incorrect, setting response message.');
                        $message = "❌ Your solution output doesn't match the expected result. Please try again.";
                    } else {
                        Log::info('Solution is correct, setting response message.');
                        $message = "✅ Solution and Results are Correct. Redirecting to Challenge Page...";
                    }
                    
                    // Ensure only the correct response is returned
                    $response = [
                        'success' => true,
                        'is_correct' => $isCorrect,
                        'message' => $message
                    ];
                    
                    // Only add redirect URL if the answer is correct
                    if ($isCorrect && $challenge) {
                        $response['redirect'] = route('challenge', $challenge->id);
                        $response['with_message'] = true;
                    }
                    
                    return response()->json($response);
                    
                }
                
                // Update the student answer with the modified output
                $studentAnswer->output = $data['output'];
                
                // Log the final state before saving
                Log::info('Final state before saving:', [
                    'is_correct' => $isCorrect,
                    'output' => $studentAnswer->output
                ]);
            } catch (\Exception $e) {
                Log::error('Error checking answer:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $isCorrect = false;
            }
            
            $studentAnswer->is_correct = $isCorrect;
            $studentAnswer->save();

            // If the answer is correct, update user progress and award points
            if ($isCorrect) {
                $user = User::find($userId);
                $pointsToAward = $task->points_reward ?? 0;
                
                // Award points to the user if the points column exists
                if ($pointsToAward > 0 && $user) {
                    if (Schema::hasColumn('users', 'points')) {
                        $user->increment('points', $pointsToAward);
                        Log::info("Awarded $pointsToAward points to user $userId");
                    } else {
                        Log::warning("Could not award points: points column does not exist in users table");
                    }
                }
                
                // Update user-challenge relationship to track progress
                if ($challenge) {
                    $userChallenge = DB::table('user_challenges')
                        ->where('user_id', $userId)
                        ->where('challenge_id', $challenge->id)
                        ->first();
                    
                    if ($userChallenge) {
                        // Update existing record
                        $totalTasks = $challenge->tasks()->count();
                        $completedTasks = StudentAnswer::where('user_id', $userId)
                            ->whereIn('task_id', $challenge->tasks()->pluck('id'))
                            ->where('is_correct', true)
                            ->distinct('task_id')
                            ->count();
                        
                        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                        $isCompleted = $completedTasks >= $totalTasks;
                        
                        DB::table('user_challenges')
                            ->where('user_id', $userId)
                            ->where('challenge_id', $challenge->id)
                            ->update([
                                'progress' => $progress,
                                'status' => $isCompleted ? 'completed' : 'in_progress',
                                'completed_at' => $isCompleted ? now() : null
                            ]);
                            
                        // If challenge is completed, award additional points
                        if ($isCompleted && $user) {
                            $challengePoints = $challenge->points_reward ?? 0;
                            if ($challengePoints > 0) {
                                if (Schema::hasColumn('users', 'points')) {
                                    $user->increment('points', $challengePoints);
                                    Log::info("Awarded $challengePoints challenge completion points to user $userId");
                                } else {
                                    Log::warning("Could not award challenge points: points column does not exist in users table");
                                }
                            }
                        }
                    } else {
                        // Create new record
                        DB::table('user_challenges')->insert([
                            'user_id' => $userId,
                            'challenge_id' => $challenge->id,
                            'status' => 'in_progress',
                            'progress' => (1 / $challenge->tasks()->count()) * 100,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }

            // Log the response being sent
            Log::info('Sending response:', [
                'success' => true,
                'is_correct' => $isCorrect,
                'message' => $isCorrect 
                    ? 'Your solution is correct!' 
                    : 'Your solution output doesn\'t match the expected result. Please try again.',
                'has_redirect' => $isCorrect && $challenge
            ]);

            // Prepare response
            $response = [
                'success' => true,
                'is_correct' => $isCorrect,
                'message' => $isCorrect 
                    ? 'Your solution is correct!' 
                    : 'Your solution output doesn\'t match the expected result. Please try again.'
            ];
            
            // Only add redirect URL if the answer is correct
            if ($isCorrect && $challenge) {
                $response['redirect'] = route('challenge', $challenge->id);
                $response['with_message'] = true;
            }

            return response()->json($response);

        } catch (\Exception $e) {
            // Log the detailed error
            Log::error('Solution submission error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit solution: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}