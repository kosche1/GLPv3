<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricalTimelineMaze extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'historical_timeline_mazes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all questions for the historical timeline maze.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(HistoricalTimelineMazeQuestion::class);
    }

    /**
     * Get easy difficulty questions for the historical timeline maze.
     */
    public function easyQuestions(): HasMany
    {
        return $this->questions()->where('difficulty', 'easy');
    }

    /**
     * Get medium difficulty questions for the historical timeline maze.
     */
    public function mediumQuestions(): HasMany
    {
        return $this->questions()->where('difficulty', 'medium');
    }

    /**
     * Get hard difficulty questions for the historical timeline maze.
     */
    public function hardQuestions(): HasMany
    {
        return $this->questions()->where('difficulty', 'hard');
    }

    /**
     * Get all events for the historical timeline maze.
     */
    public function events(): HasMany
    {
        return $this->hasMany(HistoricalTimelineMazeEvent::class);
    }

    /**
     * Get events for a specific era.
     */
    public function eraEvents(string $era): HasMany
    {
        return $this->events()->where('era', $era)->orderBy('order');
    }

    /**
     * Get all progress records for the historical timeline maze.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(HistoricalTimelineMazeProgress::class);
    }

    /**
     * Get all leaderboard entries for the historical timeline maze.
     */
    public function leaderboard(): HasMany
    {
        return $this->hasMany(HistoricalTimelineMazeLeaderboard::class);
    }
}
