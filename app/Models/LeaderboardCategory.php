<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "description",
        "metric",
        "timeframe",
        "is_active",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "boolean",
    ];

    /**
     * Get the leaderboard entries for this category.
     */
    public function entries()
    {
        return $this->hasMany(LeaderboardEntry::class);
    }
}
