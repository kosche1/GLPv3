<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ForumTopic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'forum_category_id',
        'views_count',
        'likes_count',
        'comments_count',
        'is_pinned',
        'is_locked',
        'last_activity_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            if (empty($topic->slug)) {
                $topic->slug = Str::slug($topic->title);
            }
            $topic->last_activity_at = now();
        });
    }

    /**
     * Get the user that owns the topic.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the topic belongs to.
     */
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id');
    }

    /**
     * Get the comments for the topic.
     */
    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }

    /**
     * Get the likes for the topic.
     */
    public function likes()
    {
        return $this->morphMany(ForumLike::class, 'likeable');
    }

    /**
     * Get the views for the topic.
     */
    public function views()
    {
        return $this->hasMany(ForumTopicView::class, 'forum_topic_id');
    }

    /**
     * Check if a user has viewed this topic.
     *
     * @param int $userId
     * @return bool
     */
    public function hasBeenViewedByUser($userId)
    {
        return $this->views()->where('user_id', $userId)->exists();
    }

    /**
     * Record a view for this topic by a user.
     *
     * @param int $userId
     * @return void
     */
    public function recordView($userId)
    {
        if (!$this->hasBeenViewedByUser($userId)) {
            $this->views()->create([
                'user_id' => $userId,
                'viewed_at' => now(),
            ]);
            $this->increment('views_count');
        }
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
