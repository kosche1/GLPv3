<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LevelUp\Experience\Models\Experience as BaseExperience;

class Experience extends BaseExperience
{
    use HasFactory;

    /**
     * Additional relationships or extensions can be added here
     */

    /**
     * Award experience points to user from task completion
     * 
     * @param \App\Models\User $user
     * @param \App\Models\Task $task
     * @return void
     */
    public static function awardTaskPoints(User $user, Task $task): void
    {
        if ($task->points_reward > 0) {
            $user->addPoints(
                amount: $task->points_reward,
                reason: "Completed task: {$task->name}"
            );
        }
    }
}
