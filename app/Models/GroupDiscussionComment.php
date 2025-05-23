<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupDiscussionComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_discussion_id',
        'user_id',
        'content',
        'parent_id',
    ];

    /**
     * Get the discussion that owns the comment.
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(GroupDiscussion::class, 'group_discussion_id');
    }

    /**
     * Get the user who created the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment if this is a reply.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(GroupDiscussionComment::class, 'parent_id');
    }

    /**
     * Get the replies to this comment.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(GroupDiscussionComment::class, 'parent_id')
            ->orderBy('created_at', 'asc');
    }
}
