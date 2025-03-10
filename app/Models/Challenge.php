<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LevelUp\Experience\Models\Achievement;

class Challenge extends Model
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
        "start_date",
        "end_date",
        "points_reward",
        "difficulty_level",
        "is_active",
        "max_participants",
        "completion_criteria",
        "additional_rewards",
        "required_level",
        // IT-focused challenge types
        "challenge_type",
        "time_limit",
        "challenge_content",
        "programming_language", // New field for programming language focus
        "tech_category",       // New field for categorizing tech topics
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
     * Determine if the challenge is currently active based on dates.
     *
     * @return bool
     */
    public function isCurrentlyActive()
    {
        $now = now();
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

    // Rest of the relationships remain the same
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
}
