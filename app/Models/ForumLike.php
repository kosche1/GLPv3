<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
        'is_like',
    ];

    protected $casts = [
        'is_like' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($like) {
            // Update the likeable item's likes count
            $likeable = $like->likeable;
            if ($likeable) {
                $count = $likeable->likes()->where('is_like', true)->count() - 
                         $likeable->likes()->where('is_like', false)->count();
                $likeable->update(['likes_count' => $count]);
            }
        });

        static::updated(function ($like) {
            // Update the likeable item's likes count
            $likeable = $like->likeable;
            if ($likeable) {
                $count = $likeable->likes()->where('is_like', true)->count() - 
                         $likeable->likes()->where('is_like', false)->count();
                $likeable->update(['likes_count' => $count]);
            }
        });

        static::deleted(function ($like) {
            // Update the likeable item's likes count
            $likeable = $like->likeable;
            if ($likeable) {
                $count = $likeable->likes()->where('is_like', true)->count() - 
                         $likeable->likes()->where('is_like', false)->count();
                $likeable->update(['likes_count' => $count]);
            }
        });
    }

    /**
     * Get the likeable model.
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the like.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
