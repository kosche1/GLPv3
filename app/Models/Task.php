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
        "additional_rewards",
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
        "additional_rewards" => "array",
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
        
        // For output comparison tasks, check against the answer key
        if (isset($studentAnswer['output']) && !empty($this->answer_key)) {
            // If answer_key is an array, convert to JSON string for comparison
            $answerKeyString = is_array($this->answer_key) 
                ? json_encode($this->answer_key) 
                : $this->answer_key;
                
            // Normalize both strings (trim whitespace, convert to lowercase)
            $normalizedOutput = trim(strtolower($studentAnswer['output']));
            $normalizedAnswerKey = trim(strtolower($answerKeyString));
            
            // Check if the normalized output matches the answer key
            return $normalizedOutput === $normalizedAnswerKey;
        }
        
        // For other types of tasks or if no answer key is provided
        // You might want to implement other checking logic here
        
        return false;
    }
}
