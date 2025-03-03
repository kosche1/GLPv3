<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "leaderboard_category_id",
        "user_id",
        "score",
        "rank",
        "period_start",
        "period_end",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "period_start" => "datetime",
        "period_end" => "datetime",
    ];

    /**
     * Get the leaderboard category.
     */
    public function category()
    {
        return $this->belongsTo(
            LeaderboardCategory::class,
            "leaderboard_category_id"
        );
    }

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
