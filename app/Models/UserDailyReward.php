<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyReward extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "daily_reward_tier_id",
        "claimed_at",
        "streak_date",
        "current_streak",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "claimed_at" => "datetime",
        "streak_date" => "date",
    ];

    /**
     * Get the user who claimed this reward.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reward tier that was claimed.
     */
    public function rewardTier()
    {
        return $this->belongsTo(DailyRewardTier::class, "daily_reward_tier_id");
    }
}
