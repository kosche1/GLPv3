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
            // Log the incoming request data for debugging
            Log::info('Text solution submission request data:', [
                'request_data' => $request->all()
            ]);

            // Log the entire request for debugging
            Log::info('Full request data:', [
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

            // Create student answer record with the submitted text in the submitted_text column
            $studentAnswer = StudentAnswer::create([
                'user_id' => $userId,
                'task_id' => $taskId,
                'submitted_text' => $submittedText, // Store in submitted_text column
                'status' => 'submitted',
                'is_correct' => $isCorrect
            ]);

            // Log the created record for verification
            Log::info('Student answer created with the following data:', [
                'id' => $studentAnswer->id,
                'user_id' => $userId,
                'task_id' => $taskId,
                'submitted_text' => $submittedText,
                'status' => 'submitted',
                'is_correct' => $isCorrect
            ]);

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
            Log::error('Error submitting answer: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit answer: ' . $e->getMessage()
            ], 500);
        }
    }
}