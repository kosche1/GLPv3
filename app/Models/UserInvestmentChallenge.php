<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvestmentChallenge extends Model
{
    protected $fillable = [
        'user_id',
        'investment_challenge_id',
        'status',
        'progress',
        'start_date',
        'end_date',
        'submitted_at',
        'strategy',
        'learnings',
        'grade',
        'feedback'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the challenge.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the challenge that this user challenge belongs to.
     */
    public function challenge()
    {
        return $this->belongsTo(InvestmentChallenge::class, 'investment_challenge_id');
    }

    /**
     * Calculate days remaining until the challenge ends.
     */
    public function getDaysRemainingAttribute()
    {
        if (!$this->end_date) {
            return 0;
        }

        $now = now();
        if ($now > $this->end_date) {
            return 0;
        }

        return $now->diffInDays($this->end_date);
    }
}
