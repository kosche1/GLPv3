<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperienceHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "action_type",
        "points_changed",
        "points_total",
        "level_before",
        "level_after",
        "description",
        "metadata",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "metadata" => "array",
    ];

    /**
     * Get the user that owns the experience history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
