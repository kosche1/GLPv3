<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalTimelineMazeProgress extends Model
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
        'questions_answered',
        'correct_answers',
        'accuracy',
        'max_streak',
        'answers',
        'completed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'answers' => 'array',
        'completed' => 'boolean',
        'accuracy' => 'float',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the historical timeline maze that owns the progress.
     */
    public function historicalTimelineMaze(): BelongsTo
    {
        return $this->belongsTo(HistoricalTimelineMaze::class);
    }
}
