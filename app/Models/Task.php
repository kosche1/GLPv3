<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
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
        "points_reward",
        "type",
        "is_active",
        "completion_criteria",
        "additional_rewards",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "boolean",
        "completion_criteria" => "array",
        "additional_rewards" => "array",
    ];

    /**
     * Get the users working on this task.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, "user_tasks")
            ->withPivot(
                "progress",
                "completed",
                "completed_at",
                "reward_claimed",
                "reward_claimed_at"
            )
            ->withTimestamps();
    }
}
