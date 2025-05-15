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
}
