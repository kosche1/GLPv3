<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChemistryChallenge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'difficulty_level',
        'points_reward',
        'is_active',
        'challenge_data', // JSON data with experiment details
        'expected_result', // JSON data with expected outcome
        'time_limit', // in minutes
        'instructions',
        'hints',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'challenge_data' => 'json',
        'expected_result' => 'json',
        'hints' => 'json',
    ];

    /**
     * Get the attempts for this challenge.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(UserChemistryAttempt::class);
    }
}
