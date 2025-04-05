<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
        'forum_topic_id',
        'parent_id',
        'likes_count',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            // Update the topic's last activity timestamp and comment count
            $comment->topic->update([
                'last_activity_at' => now(),
                'comments_count' => $comment->topic->comments()->count(),
            ]);
        });

        static::deleted(function ($comment) {
            // Update the topic's comment count when a comment is deleted
            if ($comment->topic) {
                $comment->topic->update([
                    'comments_count' => $comment->topic->comments()->count(),
                ]);
            }
        });
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the topic that the comment belongs to.
     */
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'forum_topic_id');
    }

    /**
     * Get the parent comment.
     */
    public function parent()
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    /**
     * Get the replies to this comment.
     */
    public function replies()
    {
        return $this->hasMany(ForumComment::class, 'parent_id');
    }

    /**
     * Get the likes for the comment.
     */
    public function likes()
    {
        return $this->morphMany(ForumLike::class, 'likeable');
    }

    /**
     * Check if the comment is a reply.
     */
    public function isReply()
    {
        return $this->parent_id !== null;
    }
}
