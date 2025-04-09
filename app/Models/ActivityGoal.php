<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use App\Services\ActivityService;

class ActivityGoal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'goal_type',
        'target_value',
        'period_type',
        'start_date',
        'end_date',
        'is_completed',
        'completed_at',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'target_value' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the goal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the goal is currently active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $now = Carbon::now();
        return $this->is_active &&
               ($this->start_date === null || $now->greaterThanOrEqualTo($this->start_date)) &&
               ($this->end_date === null || $now->lessThanOrEqualTo($this->end_date));
    }

    /**
     * Get the current progress for this goal.
     *
     * @return int
     */
    public function getCurrentProgress(): int
    {
        $activityService = app(ActivityService::class);
        $userId = $this->user_id;

        switch ($this->goal_type) {
            case 'login_streak':
                return StudentAttendance::getCurrentLoginStreak($userId);

            case 'daily_activity':
                return $activityService->getCurrentDayActivityCount($userId);

            case 'weekly_activity':
                return $activityService->getCurrentWeekActivityCount($userId);

            case 'tasks_completed':
                $startDate = $this->period_type === 'all_time' ? null : $this->start_date;
                $endDate = $this->period_type === 'all_time' ? null : $this->end_date;

                $query = UserTask::where('user_id', $userId)
                    ->where('completed', true);

                if ($startDate) {
                    $query->where('completed_at', '>=', $startDate);
                }

                if ($endDate) {
                    $query->where('completed_at', '<=', $endDate);
                }

                return $query->count();

            case 'challenges_completed':
                $startDate = $this->period_type === 'all_time' ? null : $this->start_date;
                $endDate = $this->period_type === 'all_time' ? null : $this->end_date;

                $user = User::find($userId);
                $completedChallenges = 0;

                if ($user) {
                    $challenges = Challenge::with('tasks')->get();

                    foreach ($challenges as $challenge) {
                        $totalTasks = $challenge->tasks->count();
                        if ($totalTasks === 0) continue;

                        $completedTasks = UserTask::where('user_id', $userId)
                            ->whereIn('task_id', $challenge->tasks->pluck('id'))
                            ->where('completed', true);

                        if ($startDate) {
                            $completedTasks->where('completed_at', '>=', $startDate);
                        }

                        if ($endDate) {
                            $completedTasks->where('completed_at', '<=', $endDate);
                        }

                        $completedTasksCount = $completedTasks->count();

                        if ($completedTasksCount >= $totalTasks) {
                            $completedChallenges++;
                        }
                    }
                }

                return $completedChallenges;

            case 'experience_points':
                $user = User::find($userId);
                return $user ? $user->getPoints() : 0;

            default:
                return 0;
        }
    }

    /**
     * Get the progress percentage for this goal.
     *
     * @return int
     */
    public function getProgressPercentage(): int
    {
        $currentProgress = $this->getCurrentProgress();
        $targetValue = max(1, $this->target_value); // Avoid division by zero

        return min(100, round(($currentProgress / $targetValue) * 100));
    }

    /**
     * Check if the goal is completed.
     *
     * @return bool
     */
    public function checkCompletion(): bool
    {
        if ($this->is_completed) {
            return true;
        }

        $currentProgress = $this->getCurrentProgress();

        if ($currentProgress >= $this->target_value) {
            $this->is_completed = true;
            $this->completed_at = Carbon::now();
            $this->save();

            return true;
        }

        return false;
    }
}
