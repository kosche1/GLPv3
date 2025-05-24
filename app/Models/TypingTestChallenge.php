<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypingTestChallenge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'word_count',
        'time_limit',
        'test_mode',
        'target_wpm',
        'target_accuracy',
        'word_list',
        'is_active',
        'points_reward',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'word_list' => 'array',
        'is_active' => 'boolean',
        'target_wpm' => 'integer',
        'target_accuracy' => 'integer',
        'word_count' => 'integer',
        'time_limit' => 'integer',
        'points_reward' => 'integer',
    ];

    /**
     * Get the user who created this challenge.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the typing test results for this challenge.
     */
    public function results()
    {
        return $this->hasMany(TypingTestResult::class, 'challenge_id');
    }

    /**
     * Scope to get only active challenges.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by difficulty.
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Get the difficulty badge color.
     */
    public function getDifficultyColorAttribute()
    {
        return match ($this->difficulty) {
            'beginner' => 'success',
            'intermediate' => 'warning',
            'advanced' => 'danger',
            default => 'gray',
        };
    }

    /**
     * Get the test mode badge color.
     */
    public function getTestModeColorAttribute()
    {
        return match ($this->test_mode) {
            'words' => 'success',
            'time' => 'info',
            default => 'gray',
        };
    }

    /**
     * Get formatted word list for display.
     */
    public function getFormattedWordListAttribute()
    {
        if (is_array($this->word_list)) {
            return implode(', ', array_slice($this->word_list, 0, 10)) . 
                   (count($this->word_list) > 10 ? '...' : '');
        }
        return 'Default word bank';
    }
}
