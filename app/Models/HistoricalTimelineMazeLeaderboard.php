<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalTimelineMazeLeaderboard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'historical_timeline_maze_id',
        'era',
        'difficulty',
        'score',
        'time_taken',
        'accuracy',
        'username',
        'avatar',
        'rank',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'accuracy' => 'float',
    ];

    /**
     * Get the user that owns the leaderboard entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the historical timeline maze that owns the leaderboard entry.
     */
    public function historicalTimelineMaze(): BelongsTo
    {
        return $this->belongsTo(HistoricalTimelineMaze::class);
    }
}
