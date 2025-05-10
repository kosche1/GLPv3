<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserChemistryAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'chemistry_challenge_id',
        'user_solution', // JSON data with user's solution
        'status', // 'pending', 'approved', 'rejected'
        'score',
        'feedback',
        'notes',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_solution' => 'json',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the challenge that owns the attempt.
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(ChemistryChallenge::class, 'chemistry_challenge_id');
    }

    /**
     * Get the reviewer that reviewed the attempt.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
