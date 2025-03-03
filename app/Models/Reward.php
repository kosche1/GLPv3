<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["name", "description", "type", "reward_data"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "reward_data" => "array",
    ];

    /**
     * Get the user rewards.
     */
    public function userRewards()
    {
        return $this->hasMany(UserReward::class);
    }
}
