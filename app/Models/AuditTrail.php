<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditTrail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'action_type',
        'subject_type',
        'subject_name',
        'challenge_name',
        'task_name',
        'score',
        'description',
        'additional_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'additional_data' => 'array',
    ];

    /**
     * Get the user that owns the audit trail entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record a student registration event.
     *
     * @param User $user The user who registered
     * @return AuditTrail
     */
    public static function recordRegistration(User $user): AuditTrail
    {
        // Check if an entry already exists for this user's registration
        $existingEntry = self::where('user_id', $user->id)
            ->where('action_type', 'registration')
            ->first();

        if ($existingEntry) {
            \Illuminate\Support\Facades\Log::info('Using existing audit trail entry for registration', [
                'user_id' => $user->id,
                'audit_trail_id' => $existingEntry->id,
            ]);
            return $existingEntry;
        }

        try {
            $auditTrail = self::create([
                'user_id' => $user->id,
                'action_type' => 'registration',
                'description' => 'New student registration',
                'additional_data' => [
                    'email' => $user->email,
                    'registered_at' => now()->toDateTimeString(),
                ],
            ]);

            \Illuminate\Support\Facades\Log::info('New audit trail record created for registration', [
                'user_id' => $user->id,
                'audit_trail_id' => $auditTrail->id,
            ]);

            return $auditTrail;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating AuditTrail record: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'exception' => $e,
            ]);
            throw $e;
        }
    }

    /**
     * Record a challenge completion event.
     *
     * @param User $user The user who completed the challenge
     * @param Challenge $challenge The challenge that was completed
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordChallengeCompletion(User $user, Challenge $challenge, array $additionalData = []): AuditTrail
    {
        // Get subject type and name if available
        $subjectType = $challenge->subjectType ? $challenge->subjectType->name : null;
        $subjectName = null;

        if ($challenge->strand) {
            $subjectName = $challenge->strand->name;
        } elseif (isset($additionalData['subject_name'])) {
            $subjectName = $additionalData['subject_name'];
        }

        return self::create([
            'user_id' => $user->id,
            'action_type' => 'challenge_completion',
            'subject_type' => $subjectType,
            'subject_name' => $subjectName,
            'challenge_name' => $challenge->name,
            'description' => "Completed challenge: {$challenge->name}",
            'additional_data' => array_merge([
                'completed_at' => now()->toDateTimeString(),
                'points_earned' => $challenge->points_reward,
                'difficulty_level' => $challenge->difficulty_level,
            ], $additionalData),
        ]);
    }

    /**
     * Record a task submission event.
     *
     * @param User $user The user who submitted the task
     * @param Task $task The task that was submitted
     * @param StudentAnswer $answer The student's answer
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordTaskSubmission(User $user, Task $task, StudentAnswer $answer, array $additionalData = []): AuditTrail
    {
        $challenge = $task->challenge;

        // Get subject type and name if available
        $subjectType = $challenge && $challenge->subjectType ? $challenge->subjectType->name : null;
        $subjectName = null;

        if ($challenge && $challenge->strand) {
            $subjectName = $challenge->strand->name;
        } elseif (isset($additionalData['subject_name'])) {
            $subjectName = $additionalData['subject_name'];
        }

        return self::create([
            'user_id' => $user->id,
            'action_type' => 'task_submission',
            'subject_type' => $subjectType,
            'subject_name' => $subjectName,
            'challenge_name' => $challenge ? $challenge->name : null,
            'task_name' => $task->name,
            'score' => $answer->score,
            'description' => "Submitted task: {$task->name}",
            'additional_data' => array_merge([
                'submitted_at' => now()->toDateTimeString(),
                'is_correct' => $answer->is_correct,
                'status' => $answer->status,
            ], $additionalData),
        ]);
    }
}
