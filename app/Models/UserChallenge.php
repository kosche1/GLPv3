<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserChallenge extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user_challenges";

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "challenge_id",
        "status", // enrolled, in_progress, completed, failed
        "progress",
        "completed_at",
        "reward_claimed",
        "reward_claimed_at",
        "attempts",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "progress" => "integer",
        "completed_at" => "datetime",
        "reward_claimed" => "boolean",
        "reward_claimed_at" => "datetime",
        "attempts" => "integer",
    ];

    /**
     * Get the user associated with the challenge.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the challenge associated with the user.
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
