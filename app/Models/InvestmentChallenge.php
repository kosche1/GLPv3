<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentChallenge extends Model
{
    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'duration_days',
        'points_reward',
        'is_active',
        'starting_capital',
        'target_return',
        'required_stocks',
        'forbidden_stocks'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'starting_capital' => 'decimal:2',
        'target_return' => 'decimal:2',
        'required_stocks' => 'json',
        'forbidden_stocks' => 'json'
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
