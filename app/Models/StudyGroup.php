<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class StudyGroup extends Model
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
        'image',
        'created_by',
        'is_private',
        'join_code',
        'max_members',
        'focus_areas',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_private' => 'boolean',
        'focus_areas' => 'array',
    ];

    /**
     * Generate a unique join code for the group.
     *
     * @return string
     */
    public static function generateJoinCode(): string
    {
        $code = Str::random(8);

        // Ensure the code is unique
        while (self::where('join_code', $code)->exists()) {
            $code = Str::random(8);
        }

        return $code;
    }

    /**
     * Get the user who created the study group.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the users who are members of this study group.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'study_group_user')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Get the group challenges associated with this study group.
     */
    public function groupChallenges(): HasMany
    {
        return $this->hasMany(GroupChallenge::class);
    }

    /**
     * Get the discussions in this study group.
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(GroupDiscussion::class);
    }



    /**
     * Check if the group has reached its maximum number of members.
     *
     * @return bool
     */
    public function isFull(): bool
    {
        return $this->members()->count() >= $this->max_members;
    }

    /**
     * Check if a user is a member of this group.
     *
     * @param User $user
     * @return bool
     */
    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the role of a user in this group.
     *
     * @param User $user
     * @return string|null
     */
    public function getMemberRole(User $user): ?string
    {
        $membership = $this->members()->where('user_id', $user->id)->first();
        return $membership ? $membership->pivot->role : null;
    }

    /**
     * Check if a user is a leader of this group.
     *
     * @param User $user
     * @return bool
     */
    public function isLeader(User $user): bool
    {
        return $this->getMemberRole($user) === 'leader';
    }

    /**
     * Check if a user is a moderator of this group.
     *
     * @param User $user
     * @return bool
     */
    public function isModerator(User $user): bool
    {
        $role = $this->getMemberRole($user);
        return $role === 'moderator' || $role === 'leader';
    }
}
