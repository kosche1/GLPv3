<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentAnswer;
use App\Models\User;
use App\Models\Task;
use App\Models\Challenge;
use App\Models\Experience;
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

            // Get user ID from request instead of Auth facade
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'user_id' => 'required|exists:users,id',  // Add this validation
                'student_answer' => 'required|array',
                'student_answer.code' => 'required|string|max:10000',
                'student_answer.output' => 'nullable|string'
            ]);

            $userId = $validated['user_id'];  // Use this instead of auth()->user()->id


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
                'submitted_text' => $output, // Store execution output in submitted_text column
                'status' => 'submitted',
                'student_answer' => [
                    'code' => $code,
                    'language' => $language,
                    'output' => $output
                ]
            ];

            // Create the student answer record
            $studentAnswer = new StudentAnswer($data);

            // Check if the answer is correct - DEFAULT TO FALSE
            $isCorrect = false;
            try {
                // First check if the task has evaluation_type 'exact_match'
                if ($task->evaluation_type === 'exact_match') {
                    // Get the expected answer from evaluation_details
                    $evaluationDetails = $task->evaluation_details;
                    if (is_array($evaluationDetails) && isset($evaluationDetails['expected'])) {
                        $expectedAnswer = trim($evaluationDetails['expected']);
                        $cleanOutput = trim($output);
                        $isCorrect = ($cleanOutput === $expectedAnswer) && !empty($expectedAnswer) && !empty($cleanOutput);

                        // Log the comparison
                        Log::info('Exact match comparison:', [
                            'expected_answer' => $expectedAnswer,
                            'submitted_output' => $cleanOutput,
                            'is_correct' => $isCorrect
                        ]);
                    }
                } else {
                    // Fallback to expected_output
                    // Get the task's expected output
                    $expectedOutput = $task->expected_output;

                    // Convert to string if it's an array or object
                    if (is_array($expectedOutput) || is_object($expectedOutput)) {
                        $expectedOutput = (string)json_encode($expectedOutput);
                    } elseif (is_null($expectedOutput)) {
                        $expectedOutput = '';
                    } else {
                        $expectedOutput = (string)$expectedOutput;
                    }

                    // Minimal processing for both strings
                    $expectedOutput = trim($expectedOutput);
                    $cleanOutput = trim($output);

                    // BASIC STRING EQUALITY - Nothing more, nothing less
                    $isCorrect = ($cleanOutput === $expectedOutput) && !empty($expectedOutput) && !empty($cleanOutput);

                    // NEW: Enhanced string comparison with normalization
                    $normalizedOutput = $this->normalizeString($cleanOutput);
                    $normalizedExpected = $this->normalizeString($expectedOutput);
                    $isCorrect = ($normalizedOutput === $normalizedExpected) && !empty($normalizedExpected);
                }

                // Log everything for diagnosis
                Log::alert('ANSWER COMPARISON RESULT:', [
                    'task_id' => $task->id,
                    'evaluation_type' => $task->evaluation_type,
                    'student_output' => $cleanOutput ?? '',
                    'is_correct' => $isCorrect
                ]);

                // Update feedback based on result
                if ($isCorrect) {
                    $output .= "\n\n✅ Solution and Results are Correct. Redirecting to Challenge Page...";
                } else {
                    $output .= "\n\n❌ Your solution output doesn't match the expected result. Please try again.";
                    $output .= "\n\nExpected output: " . $expectedOutput;
                }

                // Update data and student answer
                $data['submitted_text'] = $output;
                $studentAnswer->submitted_text = $data['submitted_text'];

                // Force set is_correct before saving
                $studentAnswer->is_correct = $isCorrect;
            } catch (\Exception $e) {
                Log::error('Error checking answer:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $isCorrect = false;
                $studentAnswer->is_correct = false;
            }

            // Force dirty state and save
            $studentAnswer->setAttribute('is_correct', $isCorrect);
            $studentAnswer->save();

            // FINAL DATABASE VERIFICATION: Double-check that the database has the right value
            $savedAnswer = StudentAnswer::find($studentAnswer->id);
            Log::alert('DATABASE VERIFICATION:', [
                'id' => $studentAnswer->id,
                'expected_is_correct' => $isCorrect,
                'actual_is_correct' => $savedAnswer->is_correct
            ]);

            // If the saved value doesn't match, force update directly in database
            if ($savedAnswer->is_correct !== $isCorrect) {
                Log::error('MISMATCH DETECTED - Forcing database update');
                DB::table('student_answers')
                    ->where('id', $studentAnswer->id)
                    ->update(['is_correct' => $isCorrect]);
            }

            // If the answer is correct and the task has evaluation_type 'exact_match', update user progress and award points
            if ($isCorrect && $task->evaluation_type === 'exact_match') {
                $user = User::find($userId);
                $pointsToAward = $task->points_reward ?? 0;

                // Award points to the user's experience record
                if ($pointsToAward > 0 && $user) {
                    // Use the Experience model to award points
                    Experience::awardTaskPoints($user, $task);

                    Log::info("Awarded points to experience record using Experience model", [
                        'user_id' => $userId,
                        'points_awarded' => $pointsToAward,
                        'source' => 'task_completion',
                        'task_id' => $task->id,
                        'evaluation_type' => 'exact_match'
                    ]);
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
                        $wasAlreadyCompleted = $userChallenge->pivot->status === 'completed';

                        DB::table('user_challenges')
                            ->where('user_id', $userId)
                            ->where('challenge_id', $challenge->id)
                            ->update([
                                'progress' => $progress,
                                'status' => $isCompleted ? 'completed' : 'in_progress',
                                'completed_at' => $isCompleted ? now() : null
                            ]);

                        // If challenge is completed for the first time, use the User model method to trigger events
                        if ($isCompleted && !$wasAlreadyCompleted && $user) {
                            try {
                                // Use the User model method to properly trigger events and handle rewards
                                $user->updateChallengeProgress($challenge, 100);
                                Log::info("Challenge completion processed through User model for user $userId, challenge {$challenge->id}");
                            } catch (\Exception $e) {
                                Log::error("Error processing challenge completion through User model: {$e->getMessage()}", [
                                    'user_id' => $userId,
                                    'challenge_id' => $challenge->id,
                                    'trace' => $e->getTraceAsString()
                                ]);

                                // Fallback: Award points directly if User model method fails
                                $challengePoints = $challenge->points_reward ?? 0;
                                if ($challengePoints > 0) {
                                    DB::table('experiences')
                                        ->where('user_id', $userId)
                                        ->increment('experience_points', $challengePoints);
                                    Log::info("Awarded $challengePoints challenge completion experience points to user $userId (fallback)");
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

            // Prepare final response
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

    /**
     * Helper function to find the first position where two strings differ
     */
    private function findFirstDifferentChar($str1, $str2) {
        $maxLen = min(strlen($str1), strlen($str2));
        for ($i = 0; $i < $maxLen; $i++) {
            if ($str1[$i] !== $str2[$i]) {
                return "Position $i: Expected '{$str1[$i]}' Got '{$str2[$i]}'";
            }
        }
        if (strlen($str1) !== strlen($str2)) {
            return "Strings match until position $maxLen, but have different lengths";
        }
        return "No differences found";
    }

    /**
     * Normalize strings for comparison
     */
    private function normalizeString($str)
    {
        // Convert to lowercase
        $str = strtolower(trim($str));

        // Remove extra whitespace
        $str = preg_replace('/\s+/', ' ', $str);

        // Remove punctuation (optional)
        $str = preg_replace('/[^\w\s]/', '', $str);

        return $str;
    }
}