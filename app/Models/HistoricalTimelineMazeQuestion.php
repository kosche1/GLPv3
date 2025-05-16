<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalTimelineMazeQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'historical_timeline_maze_id',
        'era',
        'difficulty',
        'question',
        'options',
        'hint',
        'points',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the historical timeline maze that owns the question.
     */
    public function historicalTimelineMaze(): BelongsTo
    {
        return $this->belongsTo(HistoricalTimelineMaze::class);
    }
}
