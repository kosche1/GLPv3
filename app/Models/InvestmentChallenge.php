<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentChallenge extends Model
{
    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'duration',
        'points',
        'is_active'
    ];

    /**
     * Get the users who have started this challenge.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_investment_challenges')
            ->withPivot(['status', 'progress', 'start_date', 'end_date', 'submitted_at', 'grade'])
            ->withTimestamps();
    }

    /**
     * Get the user challenges for this challenge.
     */
    public function userChallenges()
    {
        return $this->hasMany(UserInvestmentChallenge::class);
    }
}
