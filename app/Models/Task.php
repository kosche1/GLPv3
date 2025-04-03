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
        "instructions",
        "points_reward",
        "submission_type",
        "evaluation_type",
        "evaluation_details",
        "is_active",
        "challenge_id",
        "order"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "boolean",
        "evaluation_details" => "array",
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
     * Mark task as completed for a user and award experience points
     * NOTE: This logic might need to move to an Observer on StudentAnswer
     *       to trigger *after* successful evaluation, not just submission.
     *       Keeping it here conceptually for now, but likely needs refactoring.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function completeTask(User $user): bool
    {
        // Check if the task is already completed by the user
        // This check might need to query StudentAnswer status instead of user_tasks pivot
        $userTask = $user->tasks()->where('task_id', $this->id)->first();

        if ($userTask && $userTask->pivot->completed) {
            // Or check StudentAnswer status:
            // $answer = $this->studentAnswers()->where('user_id', $user->id)->where('status', 'correct')->exists();
            // if ($answer) {
            //     return false; // Task already successfully completed
            // }
            return false; // Keeping original logic for now
        }

        // Mark the task as completed in the pivot table
        // This might be replaced by updating StudentAnswer status
        $user->tasks()->syncWithoutDetaching([
            $this->id => [
                'completed' => true,
                'completed_at' => now(),
                'progress' => 100, // Progress might not always be 100% just on completion
            ]
        ]);

        // Award experience points - SHOULD MOVE TO OBSERVER/LISTENER
        // Experience::awardTaskPoints($user, $this);

        // Update challenge progress if this task is part of a challenge
        // This also likely needs adjustment based on the new structure
        if ($this->challenge) {
            // Assuming Challenge model has an updateUserProgress method
            // $this->challenge->updateUserProgress($user);
        }

        return true;
    }
}
