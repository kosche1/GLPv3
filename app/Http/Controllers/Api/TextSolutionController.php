<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentAnswer;
use App\Models\Task;
use App\Models\User;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TextSolutionController extends Controller
{
    public function submit(Request $request)
    {
        try {
            // Log the incoming request data for debugging with more details
            Log::alert('TEXT SOLUTION SUBMISSION - REQUEST DATA:', [
                'request_data' => $request->all(),
                'request_method' => $request->method(),
                'request_path' => $request->path(),
                'request_url' => $request->url(),
                'request_ip' => $request->ip()
            ]);

            // Log the entire request for debugging
            Log::alert('TEXT SOLUTION SUBMISSION - FULL REQUEST DATA:', [
                'all' => $request->all(),
                'json' => $request->json()->all(),
                'headers' => $request->header()
            ]);

            // Try to get data from the request in any format
            $taskId = $request->input('task_id');
            $userId = $request->input('user_id');
            $studentAnswer = $request->input('student_answer', []);

            // Check if we have the required data
            if (!$taskId || !$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing required fields: task_id and user_id'
                ], 400);
            }

            // Get submitted text from any available field
            $submittedText = '';
            if (is_array($studentAnswer)) {
                $submittedText = $studentAnswer['submitted_text'] ?? $studentAnswer['output'] ?? '';
            } elseif (is_string($studentAnswer)) {
                $submittedText = $studentAnswer;
            }

            if (empty($submittedText)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No answer provided'
                ], 400);
            }

            // Verify task exists
            try {
                $task = Task::findOrFail($taskId);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid task ID'
                ], 400);
            }

            // Check if this is an Exact Match evaluation type and if there are errors in the submitted text
            if ($task->evaluation_type === 'exact_match') {
                // Check for error indicators in the submitted text
                $errorPatterns = [
                    '/ERROR/i',
                    '/error/i',
                    '/Exception/i',
                    '/exception/i'
                ];

                $hasErrors = false;
                foreach ($errorPatterns as $pattern) {
                    if (preg_match($pattern, $submittedText)) {
                        $hasErrors = true;
                        break;
                    }
                }

                if ($hasErrors) {
                    Log::info('Blocking submission with errors for Exact Match task:', [
                        'task_id' => $taskId,
                        'user_id' => $userId,
                        'evaluation_type' => $task->evaluation_type,
                        'has_errors' => $hasErrors
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot submit solution with errors. Please fix your code and try again.'
                    ], 400);
                }

                // For exact_match, also check if the expected output is defined and verify the submission matches it
                $evaluationDetails = $task->evaluation_details;
                if (is_array($evaluationDetails) && isset($evaluationDetails['expected'])) {
                    $expectedAnswer = trim($evaluationDetails['expected']);

                    // If the submitted text doesn't match the expected answer, reject it
                    if (trim($submittedText) !== $expectedAnswer) {
                        Log::info('Blocking submission that doesn\'t match expected output for Exact Match task:', [
                            'task_id' => $taskId,
                            'user_id' => $userId,
                            'expected' => $expectedAnswer,
                            'submitted' => trim($submittedText)
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' => 'Your solution doesn\'t match the expected output. Please check your code and try again.'
                        ], 400);
                    }
                }
            }

            // We already have the task object from earlier

            // Check if the answer is correct by comparing with expected answer
            $isCorrect = false;
            $cleanSubmittedText = trim($submittedText);

            // First check if the task has evaluation_type 'exact_match'
            if ($task->evaluation_type === 'exact_match') {
                // Get the expected answer from evaluation_details
                $evaluationDetails = $task->evaluation_details;
                if (is_array($evaluationDetails) && isset($evaluationDetails['expected'])) {
                    $expectedAnswer = trim($evaluationDetails['expected']);
                    $isCorrect = ($cleanSubmittedText === $expectedAnswer) && !empty($expectedAnswer) && !empty($cleanSubmittedText);

                    // Log the comparison
                    Log::info('Exact match comparison:', [
                        'expected_answer' => $expectedAnswer,
                        'submitted_text' => $cleanSubmittedText,
                        'is_correct' => $isCorrect
                    ]);
                }
            }
            // If not exact_match or no match found, fallback to expected_output
            elseif ($task->expected_output) {
                $expectedOutput = $task->expected_output;

                // Handle different types of expected output
                if (is_array($expectedOutput)) {
                    // If it's a structured expected output with type
                    if (isset($expectedOutput['type'])) {
                        switch ($expectedOutput['type']) {
                            case 'exact':
                                // Exact string match
                                $expectedValue = $expectedOutput['value'] ?? '';
                                $isCorrect = ($cleanSubmittedText === trim($expectedValue)) && !empty($expectedValue);
                                break;

                            case 'contains':
                                // Check if submitted text contains all required values
                                $requiredValues = $expectedOutput['values'] ?? [];
                                $isCorrect = true;
                                foreach ($requiredValues as $value) {
                                    if (stripos($cleanSubmittedText, $value) === false) {
                                        $isCorrect = false;
                                        break;
                                    }
                                }
                                break;

                            case 'regex':
                                // Regular expression match
                                $pattern = $expectedOutput['pattern'] ?? '';
                                $isCorrect = !empty($pattern) && preg_match($pattern, $cleanSubmittedText) === 1;
                                break;

                            default:
                                // Default to simple string comparison
                                $expectedValue = json_encode($expectedOutput);
                                $isCorrect = ($cleanSubmittedText === trim($expectedValue)) && !empty($expectedValue);
                                break;
                        }
                    } else {
                        // Simple array, convert to string for comparison
                        $expectedValue = json_encode($expectedOutput);
                        $isCorrect = ($cleanSubmittedText === trim($expectedValue)) && !empty($expectedValue);
                    }
                } else {
                    // Simple string comparison
                    $expectedValue = (string)$expectedOutput;
                    $isCorrect = ($cleanSubmittedText === trim($expectedValue)) && !empty($expectedValue) && !empty($cleanSubmittedText);
                }
            }

                // Log the comparison for expected_output
                if (isset($expectedOutput)) {
                    Log::info('Answer comparison with expected_output:', [
                        'expected_output' => $expectedOutput,
                        'submitted_text' => $cleanSubmittedText,
                        'is_correct' => $isCorrect
                    ]);
                }

            // Log before creating the student answer
            Log::alert('TEXT SOLUTION SUBMISSION - ATTEMPTING TO CREATE STUDENT ANSWER:', [
                'user_id' => $userId,
                'task_id' => $taskId,
                'submitted_text' => $submittedText,
                'status' => 'submitted',
                'is_correct' => $isCorrect
            ]);

            try {
                // Create student answer record with the submitted text in the submitted_text column
                $studentAnswer = StudentAnswer::create([
                    'user_id' => $userId,
                    'task_id' => $taskId,
                    'submitted_text' => $submittedText, // Store in submitted_text column
                    'status' => 'submitted',
                    'is_correct' => $isCorrect
                ]);

                // Log the created record for verification
                Log::alert('TEXT SOLUTION SUBMISSION - STUDENT ANSWER CREATED SUCCESSFULLY:', [
                    'id' => $studentAnswer->id,
                    'user_id' => $userId,
                    'task_id' => $taskId,
                    'submitted_text' => $submittedText,
                    'status' => 'submitted',
                    'is_correct' => $isCorrect,
                    'created_at' => $studentAnswer->created_at
                ]);

                // Double-check that the record exists in the database
                $verifyRecord = StudentAnswer::find($studentAnswer->id);
                Log::alert('TEXT SOLUTION SUBMISSION - DATABASE VERIFICATION:', [
                    'record_exists' => $verifyRecord ? 'YES' : 'NO',
                    'id' => $studentAnswer->id,
                    'verified_data' => $verifyRecord ? $verifyRecord->toArray() : 'Record not found'
                ]);
            } catch (\Exception $dbException) {
                // Log detailed database error
                Log::alert('TEXT SOLUTION SUBMISSION - DATABASE ERROR:', [
                    'error_message' => $dbException->getMessage(),
                    'error_code' => $dbException->getCode(),
                    'error_trace' => $dbException->getTraceAsString()
                ]);
                throw $dbException; // Re-throw to be caught by the outer try-catch
            }

            // If the answer is correct and the task has evaluation_type 'exact_match', award experience points
            if ($isCorrect && $task->evaluation_type === 'exact_match') {
                $user = User::find($userId);
                $pointsToAward = $task->points_reward ?? 0;

                if ($user && $pointsToAward > 0) {
                    // Use the Experience model to award points
                    Experience::awardTaskPoints($user, $task);

                    Log::info('Awarded experience points for correct answer:', [
                        'user_id' => $userId,
                        'task_id' => $taskId,
                        'points_awarded' => $pointsToAward,
                        'evaluation_type' => 'exact_match'
                    ]);
                }
            }

            Log::info('Created student answer with submitted text:', ['submitted_text' => $submittedText]);

            Log::info('Text solution submitted successfully', [
                'student_answer_id' => $studentAnswer->id,
                'user_id' => $userId,
                'task_id' => $taskId
            ]);

            return response()->json([
                'success' => true,
                'is_correct' => $isCorrect,
                'message' => $isCorrect ? 'Your answer is correct!' : 'Answer submitted successfully',
                'student_answer_id' => $studentAnswer->id,
                'submitted_text' => $submittedText,
                'stored_data' => [
                    'id' => $studentAnswer->id,
                    'user_id' => $userId,
                    'task_id' => $taskId,
                    'submitted_text' => $submittedText,
                    'status' => $studentAnswer->status,
                    'is_correct' => $isCorrect,
                    'created_at' => $studentAnswer->created_at
                ]
            ]);

        } catch (\Exception $e) {
            // Log detailed error information
            Log::alert('TEXT SOLUTION SUBMISSION - CRITICAL ERROR:', [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_class' => get_class($e),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            // Check if this is a database exception
            if ($e instanceof \Illuminate\Database\QueryException) {
                Log::alert('TEXT SOLUTION SUBMISSION - DATABASE QUERY ERROR:', [
                    'sql' => method_exists($e, 'getSql') ? $e->getSql() : 'SQL not available',
                    'bindings' => method_exists($e, 'getBindings') ? $e->getBindings() : 'Bindings not available',
                    'error_info' => $e->errorInfo ?? 'Error info not available',
                    'connection' => config('database.default'),
                    'database_path' => config('database.connections.sqlite.database')
                ]);
            }

            // Return a more detailed error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit answer: ' . $e->getMessage(),
                'error_type' => get_class($e),
                'error_code' => $e->getCode(),
                'debug_info' => app()->environment('production') ? null : [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }
}