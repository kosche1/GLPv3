<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalTimelineMazeResult extends Model
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
        'era_id',
        'difficulty',
        'score',
        'questions_attempted',
        'questions_correct',
        'accuracy_percentage',
        'time_spent_seconds',
        'completed',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'score' => 'integer',
        'questions_attempted' => 'integer',
        'questions_correct' => 'integer',
        'accuracy_percentage' => 'decimal:2',
        'time_spent_seconds' => 'integer',
        'completed' => 'boolean',
    ];

    /**
     * Get the user that owns the result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the historical timeline maze associated with this result.
     */
    public function historicalTimelineMaze(): BelongsTo
    {
        return $this->belongsTo(HistoricalTimelineMaze::class);
    }

    /**
     * Get the era associated with this result.
     */
    public function era(): BelongsTo
    {
        return $this->belongsTo(HistoricalTimelineMazeEvent::class, 'era_id');
    }

    /**
     * Get the era name attribute.
     *
     * @return string
     */
    public function getEraNameAttribute(): string
    {
        if ($this->era) {
            return $this->era->title;
        }

        return '';
    }
}
