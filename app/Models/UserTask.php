<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user_tasks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "task_id",
        "progress",
        "completed",
        "completed_at",
        "reward_claimed",
        "reward_claimed_at",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "progress" => "integer",
        "completed" => "boolean",
        "completed_at" => "datetime",
        "reward_claimed" => "boolean",
        "reward_claimed_at" => "datetime",
    ];

    /**
     * Get the user associated with the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task associated with the user.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
