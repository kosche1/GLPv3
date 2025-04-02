<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "description",
        "points_reward",
        "type",
        "is_active",
        "completion_criteria",
        "answer_key",
        "challenge_id",
        "expected_output",
        "expected_solution",
        "order"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "boolean",
        "completion_criteria" => "array",
        "answer_key" => "array",
        "expected_output" => "array",
        "expected_solution" => "array",
    ];

    /**
     * Get the users working on this task.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, "user_tasks")
            ->withPivot(
                "progress",
                "completed",
                "completed_at",
                "reward_claimed",
                "reward_claimed_at"
            )
            ->withTimestamps();
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * Check if the student's answer is correct
     * 
     * @param array $studentAnswer
     * @return bool
     */
    public function checkAnswer($studentAnswer)
    {
        // Log the student answer for debugging
        Log::info('Checking answer:', [
            'task_id' => $this->id,
            'student_answer' => $studentAnswer
        ]);
        
        // Case 1: Check against expected_output
        if (isset($studentAnswer['output']) && !empty($this->expected_output)) {
            // Get student output
            $studentOutput = $studentAnswer['output'];

            // Normalize student output based on type
            if (is_string($studentOutput)) {
                // Remove whitespace and convert to lowercase for string comparison
                $normalizedStudentOutput = $this->normalizeOutput($studentOutput);
                
                // Check if expected_output is structured or just a string
                if (isset($this->expected_output['type']) && $this->expected_output['type'] === 'exact_match') {
                    // For exact string matching
                    $expectedString = $this->expected_output['value'] ?? '';
                    return $normalizedStudentOutput === $this->normalizeOutput($expectedString);
                }
                else if (isset($this->expected_output['type']) && $this->expected_output['type'] === 'contains') {
                    // For checking if output contains specific strings
                    $expectedSubstrings = $this->expected_output['values'] ?? [];
                    foreach ($expectedSubstrings as $substring) {
                        if (strpos($normalizedStudentOutput, $this->normalizeOutput($substring)) === false) {
                            return false; // If any required substring is missing, return false
                        }
                    }
                    return true; // All required substrings found
                }
                else if (isset($this->expected_output['type']) && $this->expected_output['type'] === 'regex') {
                    // For regex pattern matching
                    $pattern = $this->expected_output['pattern'] ?? '';
                    return !empty($pattern) && preg_match($pattern, $studentOutput);
                }
                else {
                    // Default: try direct comparison with expected_output
                    $expectedOutput = is_array($this->expected_output) && isset($this->expected_output['value']) 
                        ? $this->expected_output['value'] 
                        : json_encode($this->expected_output);
                    
                    return $normalizedStudentOutput === $this->normalizeOutput($expectedOutput);
                }
            }
            else if (is_array($studentOutput)) {
                // For array/structured output (like JSON)
                // If expected_output is an array of key-value pairs to match
                if (isset($this->expected_output['type']) && $this->expected_output['type'] === 'key_value_match') {
                    $requiredKeyValues = $this->expected_output['values'] ?? [];
                    foreach ($requiredKeyValues as $key => $value) {
                        if (!isset($studentOutput[$key]) || $studentOutput[$key] != $value) {
                            return false;
                        }
                    }
                    return true;
                }
                else {
                    // Direct comparison of arrays (order might matter)
                    $expectedArray = is_array($this->expected_output) && isset($this->expected_output['values']) 
                        ? $this->expected_output['values'] 
                        : $this->expected_output;
                    
                    return json_encode($studentOutput) === json_encode($expectedArray);
                }
            }
        }
        
        // Case 2: Fall back to answer_key if expected_output doesn't match or is empty
        if (isset($studentAnswer['output']) && !empty($this->answer_key)) {
            // If answer_key is an array, convert to JSON string for comparison
            $answerKeyString = is_array($this->answer_key) 
                ? json_encode($this->answer_key) 
                : $this->answer_key;
                
            // Normalize both strings (trim whitespace, convert to lowercase)
            $normalizedOutput = $this->normalizeOutput($studentAnswer['output']);
            $normalizedAnswerKey = $this->normalizeOutput($answerKeyString);
            
            // Check if the normalized output matches the answer key
            return $normalizedOutput === $normalizedAnswerKey;
        }
        
        // For other types of tasks or if no expected output/answer key is provided
        return false;
    }
    
    /**
     * Normalize output for comparison
     * 
     * @param string $output
     * @return string
     */
    private function normalizeOutput($output)
    {
        if (!is_string($output)) {
            return json_encode($output);
        }
        
        // Convert to lowercase, trim whitespace, and normalize newlines
        $normalized = strtolower(trim($output));
        
        // Replace multiple spaces with a single space
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        
        // Remove any punctuation that might not matter for comparison
        $normalized = str_replace(['.', ',', ';', ':', '!', '?'], '', $normalized);
        
        return $normalized;
    }
    
    /**
     * Mark task as completed for a user and award experience points
     * 
     * @param \App\Models\User $user
     * @return bool
     */
    public function completeTask(User $user): bool
    {
        // Check if the task is already completed by the user
        $userTask = $user->tasks()->where('task_id', $this->id)->first();
        
        if ($userTask && $userTask->pivot->completed) {
            return false; // Task already completed
        }
        
        // Mark the task as completed
        $user->tasks()->syncWithoutDetaching([
            $this->id => [
                'completed' => true,
                'completed_at' => now(),
                'progress' => 100,
            ]
        ]);
        
        // Award experience points
        Experience::awardTaskPoints($user, $this);
        
        // Update challenge progress if this task is part of a challenge
        if ($this->challenge) {
            $this->challenge->updateUserProgress($user);
        }
        
        return true;
    }
}
