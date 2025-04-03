<?php

namespace App\Services;

use App\Models\StudentAnswer;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class AnswerEvaluationService
{
    /**
     * Evaluate a student's answer based on the associated task's evaluation criteria.
     *
     * @param StudentAnswer $studentAnswer The student answer record to evaluate.
     * @return void
     */
    public function evaluate(StudentAnswer $studentAnswer): void
    {
        $task = $studentAnswer->task;
        if (!$task) {
            Log::error("Evaluation failed: Task not found for StudentAnswer ID: {$studentAnswer->id}");
            // Optionally update the answer status to 'evaluation_error'
            // $studentAnswer->update(['status' => 'evaluation_error', 'feedback' => 'Task not found.']);
            return;
        }

        Log::info("Evaluating StudentAnswer ID: {$studentAnswer->id} for Task ID: {$task->id} ({$task->evaluation_type})");

        try {
            switch ($task->evaluation_type) {
                case 'automated':
                    $this->evaluateAutomated($studentAnswer, $task);
                    break;
                case 'manual':
                    // Manual evaluation requires intervention. Set status maybe?
                    $studentAnswer->update(['status' => 'pending_manual_evaluation']);
                    Log::info("StudentAnswer ID: {$studentAnswer->id} marked for manual evaluation.");
                    break;
                case 'code': // Example specific type
                    $this->evaluateCode($studentAnswer, $task);
                    break;
                 case 'file': // Example specific type
                    $this->evaluateFile($studentAnswer, $task);
                    break;
                // Add more cases as needed
                default:
                    Log::warning("Unsupported evaluation type '{$task->evaluation_type}' for Task ID: {$task->id}");
                    $studentAnswer->update(['status' => 'evaluation_error', 'feedback' => "Unsupported evaluation type: {$task->evaluation_type}"]);
            }
        } catch (\Exception $e) {
            Log::error("Evaluation error for StudentAnswer ID: {$studentAnswer->id}. Error: " . $e->getMessage());
            $studentAnswer->update(['status' => 'evaluation_error', 'feedback' => 'An error occurred during evaluation.']);
        }
    }

    /**
     * Handle automated evaluation logic based on evaluation_details.
     */
    protected function evaluateAutomated(StudentAnswer $studentAnswer, Task $task): void
    {
        $details = $task->evaluation_details ?? [];
        $matchType = $details['match_type'] ?? null;
        $submittedText = $studentAnswer->submitted_text ?? '';

        $isCorrect = false;
        $score = 0;
        $feedback = 'Evaluation could not be performed based on task configuration.'; // Default feedback

        try {
            switch ($matchType) {
                case 'exact':
                    $expectedAnswer = $details['expected_answer'] ?? null;
                    $caseSensitive = $details['case_sensitive'] ?? false;
                    if ($expectedAnswer === null) {
                        Log::warning("Automated evaluation (exact) failed: expected_answer missing in evaluation_details for Task ID: {$task->id}");
                        $feedback = 'Task configuration error: Expected answer not set.';
                    } else {
                        if ($caseSensitive) {
                            $isCorrect = $submittedText === $expectedAnswer;
                        } else {
                            $isCorrect = strcasecmp($submittedText, $expectedAnswer) === 0;
                        }
                        
                        if ($isCorrect) {
                            $score = $task->points_reward;
                            $feedback = 'Correct answer.';
                        } else {
                            $feedback = 'Submitted answer does not match the expected answer.';
                        }
                    }
                    break;

                case 'regex':
                    $pattern = $details['pattern'] ?? null;
                    if ($pattern === null) {
                        Log::warning("Automated evaluation (regex) failed: pattern missing in evaluation_details for Task ID: {$task->id}");
                        $feedback = 'Task configuration error: Regex pattern not set.';
                    } else {
                        // Validate the pattern to prevent errors
                        if (@preg_match($pattern, '') === false) {
                             Log::error("Automated evaluation (regex) failed: Invalid pattern '{$pattern}' for Task ID: {$task->id}");
                             $feedback = 'Task configuration error: Invalid regex pattern.';
                        } else {
                            $isCorrect = preg_match($pattern, $submittedText) === 1;
                            if ($isCorrect) {
                                $score = $task->points_reward;
                                $feedback = 'Answer format is correct.';
                            } else {
                                $feedback = $details['feedback_on_fail'] ?? 'Answer does not match the required pattern.';
                            }
                        }
                    }
                    break;

                default:
                    Log::warning("Unsupported or missing match_type '{$matchType}' in evaluation_details for automated Task ID: {$task->id}");
                    $feedback = "Unsupported automated evaluation type specified in task configuration ('{$matchType}').";
                    break;
            }
        } catch (\Exception $e) {
            // Catch potential errors during evaluation (e.g., invalid regex)
            Log::error("Exception during automated evaluation for StudentAnswer ID: {$studentAnswer->id}. Error: " . $e->getMessage());
            $isCorrect = false;
            $score = 0;
            $feedback = 'An unexpected error occurred during automated evaluation.';
        }

        $this->updateAnswer($studentAnswer, $isCorrect, $score, $feedback);
        Log::info("Automated evaluation completed for StudentAnswer ID: {$studentAnswer->id}. Type: {$matchType}, Correct: " . ($isCorrect ? 'Yes' : 'No'));
    }

    /**
     * Placeholder for code evaluation logic.
     */
    protected function evaluateCode(StudentAnswer $studentAnswer, Task $task): void
    {
        // TODO: Implement code execution/testing logic
        // This could involve calling external services, running code in a sandbox, etc.
        // Use $studentAnswer->submitted_text or $studentAnswer->submitted_file_path
        // Use $task->evaluation_details for test cases, expected output, etc.
        Log::warning("Code evaluation not yet implemented for StudentAnswer ID: {$studentAnswer->id}.");

        // Placeholder result
        $isCorrect = false;
        $score = 0;
        $feedback = 'Code evaluation is not yet implemented.';

        $this->updateAnswer($studentAnswer, $isCorrect, $score, $feedback);
    }

     /**
     * Placeholder for file evaluation logic.
     */
    protected function evaluateFile(StudentAnswer $studentAnswer, Task $task): void
    {
        // TODO: Implement file analysis logic
        // Check file existence, type, content based on $task->evaluation_details
        // Use $studentAnswer->submitted_file_path
        Log::warning("File evaluation not yet implemented for StudentAnswer ID: {$studentAnswer->id}.");

        // Placeholder result
        $isCorrect = false;
        $score = 0;
        $feedback = 'File evaluation is not yet implemented.';

        $this->updateAnswer($studentAnswer, $isCorrect, $score, $feedback);
    }


    /**
     * Update the StudentAnswer model with evaluation results.
     */
    protected function updateAnswer(StudentAnswer $studentAnswer, bool $isCorrect, ?int $score, ?string $feedback):
    void
    {
        $studentAnswer->update([
            'is_correct' => $isCorrect,
            'score' => $score,
            'feedback' => $feedback,
            'status' => 'evaluated',
            'evaluated_at' => now(),
            // 'evaluated_by' => null, // Or set to a system user ID for automated evaluations
        ]);
    }
} 