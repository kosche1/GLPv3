<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRewardTier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "day_number",
        "points_reward",
        "reward_type",
        "reward_data",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "reward_data" => "array",
    ];

    /**
     * Get the users who have claimed this reward tier.
     */
    public function userRewards()
    {
        return $this->hasMany(UserDailyReward::class);
    }
}
