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
     * Get the effective timestamp for display.
     * This will use timestamps from additional_data if available.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getEffectiveTimestampAttribute()
    {
        // Check for specific timestamp fields in additional_data
        if (is_array($this->additional_data)) {
            $timestampFields = ['registered_at', 'completed_at', 'submitted_at'];

            foreach ($timestampFields as $field) {
                if (isset($this->additional_data[$field])) {
                    return \Illuminate\Support\Carbon::parse($this->additional_data[$field])
                        ->setTimezone(config('app.timezone'));
                }
            }
        }

        // Fall back to created_at if no timestamp found in additional_data
        return $this->created_at;
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
     * @param Challenge|GroupChallenge $challenge The challenge that was completed
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordChallengeCompletion(User $user, $challenge, array $additionalData = []): AuditTrail
    {
        // Get subject type and name if available
        $subjectType = null;
        $subjectName = null;
        $challengeType = 'challenge';

        // Handle regular Challenge model
        if ($challenge instanceof Challenge) {
            $subjectType = $challenge->subjectType ? $challenge->subjectType->name : null;
            if ($challenge->strand) {
                $subjectName = $challenge->strand->name;
            }
        }
        // Handle GroupChallenge model
        elseif ($challenge instanceof GroupChallenge) {
            $challengeType = 'group_challenge';
            if ($challenge->category) {
                $subjectName = $challenge->category->name;
            }
        }
        // Handle generic challenge objects (like investment challenges)
        elseif (is_object($challenge)) {
            $challengeType = $additionalData['challenge_type'] ?? 'challenge';
        }

        // Allow override from additional data
        if (isset($additionalData['subject_name'])) {
            $subjectName = $additionalData['subject_name'];
        }
        if (isset($additionalData['subject_type'])) {
            $subjectType = $additionalData['subject_type'];
        }

        // Determine score for the audit trail
        $score = null;
        if (isset($additionalData['score'])) {
            $score = $additionalData['score'];
        } elseif (isset($additionalData['wpm_achieved'])) {
            // For typing tests, use WPM as score
            $score = $additionalData['wpm_achieved'];
        } elseif (isset($challenge->points_reward)) {
            // For challenges with points, use points as score
            $score = $challenge->points_reward;
        }

        return self::create([
            'user_id' => $user->id,
            'action_type' => 'challenge_completion',
            'subject_type' => $subjectType,
            'subject_name' => $subjectName,
            'challenge_name' => $challenge->name,
            'score' => $score,
            'description' => "Completed {$challengeType}: {$challenge->name}",
            'additional_data' => array_merge([
                'completed_at' => now()->toDateTimeString(),
                'points_earned' => $challenge->points_reward ?? 0,
                'difficulty_level' => $challenge->difficulty_level ?? null,
                'challenge_type' => $challengeType,
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

    /**
     * Record a task evaluation event by an admin or faculty.
     *
     * @param mixed $admin The admin/faculty who evaluated the task
     * @param StudentAnswer $answer The student's answer that was evaluated
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordTaskEvaluation($admin, StudentAnswer $answer, array $additionalData = []): AuditTrail
    {
        $task = $answer->task;
        $student = $answer->user;
        $challenge = $task ? $task->challenge : null;

        // Get subject type and name if available
        $subjectType = $challenge && $challenge->subjectType ? $challenge->subjectType->name : null;
        $subjectName = null;

        if ($challenge && $challenge->strand) {
            $subjectName = $challenge->strand->name;
        } elseif (isset($additionalData['subject_name'])) {
            $subjectName = $additionalData['subject_name'];
        }

        return self::create([
            'user_id' => $admin->id,
            'action_type' => 'task_evaluation',
            'subject_type' => $subjectType,
            'subject_name' => $subjectName,
            'challenge_name' => $challenge ? $challenge->name : null,
            'task_name' => $task ? $task->name : null,
            'score' => $answer->score,
            'description' => "Evaluated task submission by {$student->name}",
            'additional_data' => array_merge([
                'evaluated_at' => now()->toDateTimeString(),
                'student_id' => $student->id,
                'student_name' => $student->name,
                'is_correct' => $answer->is_correct,
                'feedback' => $answer->feedback,
            ], $additionalData),
        ]);
    }

    /**
     * Record a challenge creation event by an admin or faculty.
     *
     * @param mixed $admin The admin/faculty who created the challenge
     * @param Challenge $challenge The challenge that was created
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordChallengeCreation($admin, Challenge $challenge, array $additionalData = []): AuditTrail
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
            'user_id' => $admin->id,
            'action_type' => 'challenge_creation',
            'subject_type' => $subjectType,
            'subject_name' => $subjectName,
            'challenge_name' => $challenge->name,
            'description' => "Created challenge: {$challenge->name}",
            'additional_data' => array_merge([
                'created_at' => now()->toDateTimeString(),
                'difficulty_level' => $challenge->difficulty_level,
                'points_reward' => $challenge->points_reward,
                'is_active' => $challenge->is_active,
            ], $additionalData),
        ]);
    }

    /**
     * Record a task creation event by an admin or faculty.
     *
     * @param mixed $admin The admin/faculty who created the task
     * @param Task $task The task that was created
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordTaskCreation($admin, Task $task, array $additionalData = []): AuditTrail
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
            'user_id' => $admin->id,
            'action_type' => 'task_creation',
            'subject_type' => $subjectType,
            'subject_name' => $subjectName,
            'challenge_name' => $challenge ? $challenge->name : null,
            'task_name' => $task->name,
            'description' => "Created task: {$task->name}",
            'additional_data' => array_merge([
                'created_at' => now()->toDateTimeString(),
                'points_reward' => $task->points_reward,
                'is_active' => $task->is_active,
            ], $additionalData),
        ]);
    }

    /**
     * Record a user login event.
     *
     * @param mixed $user The user who logged in
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordLogin($user, array $additionalData = []): AuditTrail
    {
        // Determine user role for better description
        $userType = 'User';
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('admin')) {
                $userType = 'Admin';
            } elseif ($user->hasRole('faculty')) {
                $userType = 'Teacher';
            } elseif ($user->hasRole('student')) {
                $userType = 'Student';
            }
        }

        \Illuminate\Support\Facades\Log::info('Creating audit trail entry for login', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_type' => $userType
        ]);

        try {
            $entry = self::create([
                'user_id' => $user->id,
                'action_type' => 'login',
                'description' => "{$userType} login: {$user->name}",
                'additional_data' => array_merge([
                    'login_at' => now()->toDateTimeString(),
                    'email' => $user->email,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'user_type' => $userType,
                ], $additionalData),
            ]);

            \Illuminate\Support\Facades\Log::info('Successfully created audit trail entry for login', [
                'audit_trail_id' => $entry->id
            ]);

            return $entry;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating audit trail entry for login', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Record a user logout event.
     *
     * @param mixed $user The user who logged out
     * @param array $additionalData Additional data to store
     * @return AuditTrail
     */
    public static function recordLogout($user, array $additionalData = []): AuditTrail
    {
        // Determine user role for better description
        $userType = 'User';
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('admin')) {
                $userType = 'Admin';
            } elseif ($user->hasRole('faculty')) {
                $userType = 'Teacher';
            } elseif ($user->hasRole('student')) {
                $userType = 'Student';
            }
        }

        \Illuminate\Support\Facades\Log::info('Creating audit trail entry for logout', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_type' => $userType
        ]);

        try {
            $entry = self::create([
                'user_id' => $user->id,
                'action_type' => 'logout',
                'description' => "{$userType} logout: {$user->name}",
                'additional_data' => array_merge([
                    'logout_at' => now()->toDateTimeString(),
                    'email' => $user->email,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'user_type' => $userType,
                ], $additionalData),
            ]);

            \Illuminate\Support\Facades\Log::info('Successfully created audit trail entry for logout', [
                'audit_trail_id' => $entry->id
            ]);

            return $entry;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating audit trail entry for logout', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
