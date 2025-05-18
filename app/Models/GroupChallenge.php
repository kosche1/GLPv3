<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupChallenge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'study_group_id',
        'created_by',
        'start_date',
        'end_date',
        'points_reward',
        'difficulty_level',
        'is_active',
        'completion_criteria',
        'additional_rewards',
        'category_id',
        'challenge_type',
        'time_limit',
        'challenge_content',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'additional_rewards' => 'array',
    ];

    /**
     * Get the study group that owns the challenge.
     */
    public function studyGroup(): BelongsTo
    {
        return $this->belongsTo(StudyGroup::class);
    }

    /**
     * Get the user who created the challenge.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the category of the challenge.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tasks associated with this challenge.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(GroupChallengeTask::class);
    }

    /**
     * Get the users participating in this challenge.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_group_challenges')
            ->withPivot(
                'status',
                'progress',
                'completed_at',
                'reward_claimed',
                'reward_claimed_at',
                'attempts'
            )
            ->withTimestamps();
    }

    /**
     * Check if the challenge is currently active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }
        
        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }
        
        return true;
    }

    /**
     * Calculate the overall completion percentage for all participants.
     *
     * @return int
     */
    public function getOverallCompletionPercentage(): int
    {
        $participants = $this->participants;
        
        if ($participants->isEmpty()) {
            return 0;
        }
        
        $totalProgress = $participants->sum(function ($participant) {
            return $participant->pivot->progress;
        });
        
        return (int) ($totalProgress / ($participants->count() * 100));
    }
}
