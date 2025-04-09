<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'message',
        'type',
        'read',
        'link',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'read' => 'boolean',
        'data' => 'array',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): void
    {
        $this->update(['read' => true]);
    }

    /**
     * Get the formatted time for display.
     */
    public function getFormattedTimeAttribute(): string
    {
        $created = $this->created_at;
        $now = now();

        if ($created->diffInMinutes($now) < 60) {
            return (int)$created->diffInMinutes($now) . ' min ago';
        } elseif ($created->diffInHours($now) < 24) {
            return $created->diffInHours($now) . ' hours ago';
        } else {
            return $created->format('M d, Y');
        }
    }
}
