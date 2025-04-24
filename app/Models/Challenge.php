<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LevelUp\Experience\Models\Achievement;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use App\Models\User;

class Challenge extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * Get the options for logging activity.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'start_date',
                'end_date',
                'points_reward',
                'difficulty_level',
                'is_active',
                'max_participants',
                'completion_criteria',
                'additional_rewards',
                'required_level',
                'category_id',
                'challenge_type',
                'time_limit',
                'programming_language',
                'tech_category',
                'subject_type',
                'image',
            ])
            ->useLogName('Challenge')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        // Set the log_name to the user's name if the causer is a user
        if ($activity->causer && $activity->causer instanceof User) {
            $activity->log_name = $activity->causer->name;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "description",
        "start_date",
        "end_date",
        "points_reward",
        "difficulty_level",
        "is_active",
        "max_participants",
        "completion_criteria",
        "additional_rewards",
        "required_level",
        "category_id",
        // IT-focused challenge types
        "challenge_type",
        "time_limit",
        "challenge_content",
        "programming_language", // New field for programming language focus
        "tech_category",       // New field for categorizing tech topics
        "subject_type",        // Field for categorizing subjects (core, applied, specialized)
        "image",              // Field for storing challenge image path
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "start_date" => "datetime",
        "end_date" => "datetime",
        "is_active" => "boolean",
        "completion_criteria" => "array",
        "additional_rewards" => "array",
        "challenge_content" => "array",
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function (Challenge $challenge) {
            // After a challenge is saved, recalculate its points reward
            // to ensure it's always up-to-date, but only if it wasn't explicitly set
            if (!request()->has('points_reward')) {
                $challenge->updatePointsReward();
            }
        });
    }

    /**
     * Calculate and update the total points reward based on associated tasks.
     *
     * @return void
     */
    public function updatePointsReward()
    {
        $totalTaskPoints = $this->tasks()->sum('points_reward');

        // Only update if there are tasks and the total is different from current value
        if ($totalTaskPoints > 0 && $totalTaskPoints != $this->points_reward) {
            $this->update(['points_reward' => $totalTaskPoints]);
        }
    }

    /**
     * Determine if the challenge is currently active based on dates.
     *
     * @return bool
     */
    public function isCurrentlyActive()
    {
        $now = Carbon::now();
        return $this->is_active &&
               $now->greaterThanOrEqualTo($this->start_date) &&
               ($this->end_date === null || $now->lessThanOrEqualTo($this->end_date));
    }

    /**
     * Get the users participating in this challenge.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, "user_challenges")
            ->withPivot(
                "status",
                "progress",
                "completed_at",
                "reward_claimed",
                "reward_claimed_at",
                "attempts"
            )
            ->withTimestamps();
    }

    /**
     * Get the badges associated with this challenge.
     */
    public function badges()
    {
        return $this->belongsToMany(
            Badge::class,
            "challenge_badges"
        )->withTimestamps();
    }

    /**
     * Get the tasks associated with this challenge.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the achievements associated with this challenge.
     */
    public function achievements()
    {
        return $this->belongsToMany(
            Achievement::class,
            "challenge_achievements"
        )->withTimestamps();
    }

    /**
     * Get the activities required for this challenge.
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, "challenge_activities")
            ->withPivot("required_count")
            ->withTimestamps();
    }

    /**
     * Get the category that owns the challenge.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
