<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupDiscussion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'study_group_id',
        'user_id',
        'title',
        'content',
        'is_pinned',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    /**
     * Get the study group that owns the discussion.
     */
    public function studyGroup(): BelongsTo
    {
        return $this->belongsTo(StudyGroup::class);
    }

    /**
     * Get the user who created the discussion.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for this discussion.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(GroupDiscussionComment::class);
    }

    /**
     * Get the root comments (not replies) for this discussion.
     */
    public function rootComments(): HasMany
    {
        return $this->hasMany(GroupDiscussionComment::class)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'asc');
    }
}
