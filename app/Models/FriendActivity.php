<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FriendActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'activity_type',
        'activity_title',
        'activity_description',
        'activity_data',
        'points_earned',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activity_data' => 'array',
        'is_public' => 'boolean',
    ];

    /**
     * Get the user who performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the likes for this activity.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ActivityLike::class);
    }

    /**
     * Check if a user has liked this activity.
     */
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the activity icon based on type.
     */
    public function getIconAttribute(): string
    {
        return match($this->activity_type) {
            'challenge_completed' => '🎓',
            'badge_earned' => '🏆',
            'level_up' => '⭐',
            'achievement_unlocked' => '🎯',
            'streak_milestone' => '🔥',
            'leaderboard_rank' => '👑',
            'study_group_joined' => '👥',
            'task_completed' => '✅',
            'points_milestone' => '💎',
            default => '📚',
        };
    }

    /**
     * Get the activity color based on type.
     */
    public function getColorAttribute(): string
    {
        return match($this->activity_type) {
            'challenge_completed' => 'blue',
            'badge_earned' => 'yellow',
            'level_up' => 'purple',
            'achievement_unlocked' => 'green',
            'streak_milestone' => 'red',
            'leaderboard_rank' => 'orange',
            'study_group_joined' => 'cyan',
            'task_completed' => 'emerald',
            'points_milestone' => 'pink',
            default => 'gray',
        };
    }

    /**
     * Scope to get public activities.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope to get activities by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope to get recent activities.
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
