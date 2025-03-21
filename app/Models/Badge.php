<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
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
        "image",
        "trigger_type",
        "trigger_conditions",
        "rarity_level",
        "is_hidden",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "trigger_conditions" => "array",
        "is_hidden" => "boolean",
    ];

    /**
     * Get the users who have earned this badge.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, "user_badges")
            ->withPivot("earned_at", "is_pinned", "is_showcased")
            ->withTimestamps();
    }
}
