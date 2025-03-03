<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "reward_id",
        "source_type",
        "source_id",
        "earned_at",
        "is_claimed",
        "claimed_at",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "earned_at" => "datetime",
        "is_claimed" => "boolean",
        "claimed_at" => "datetime",
    ];

    /**
     * Get the user who earned the reward.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reward that was earned.
     */
    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    /**
     * Get the source model that triggered this reward.
     */
    public function source()
    {
        return $this->morphTo();
    }
}
