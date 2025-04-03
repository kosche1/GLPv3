<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get regular players (not admin or moderator)
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->get();

        // Get all tasks
        $tasks = Task::all();
        // $oneTimeTasks = $tasks->where('type', 'onetime'); // Removed type filtering
        // $dailyTasks = $tasks->where('type', 'daily'); // Removed type filtering
        // $weeklyTasks = $tasks->where('type', 'weekly'); // Removed type filtering
        // $challengeTasks = $tasks->where('type', 'challenge'); // Removed type filtering

        foreach ($users as $user) {
            // Assign a random subset of tasks to each user
            $numberOfTasksToAssign = rand(5, $tasks->count()); // Assign between 5 and all tasks
            $assignedTasks = $tasks->random($numberOfTasksToAssign);

            foreach ($assignedTasks as $task) {
                $completed = rand(0, 3) === 0; // 25% chance of being completed
                $progress = $completed ? 100 : rand(0, 90); // If not completed, random progress up to 90%
                $completedAt = $completed ? now()->subDays(rand(1, 30)) : null;
                $rewardClaimed = $completed && rand(0, 1) === 1; // 50% chance of claimed reward if completed
                $rewardClaimedAt = $rewardClaimed ? $completedAt->addMinutes(rand(5, 120)) : null;

                DB::table('user_tasks')->insert([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                    'progress' => $progress,
                    'completed' => $completed,
                    'completed_at' => $completedAt,
                    'reward_claimed' => $rewardClaimed,
                    'reward_claimed_at' => $rewardClaimedAt,
                    'created_at' => now()->subDays(rand(1, 60)), // Random creation time in the last 60 days
                    'updated_at' => $completedAt ?: now()->subDays(rand(0, $completedAt ? $completedAt->diffInDays(now()) : 30)), // Update time reflects progress or completion
                ]);
            }

            // Remove the old logic based on task types
            /*
            // Assign one-time tasks (some completed, some in progress)
            foreach ($oneTimeTasks as $task) {
                // ... old code ...
            }

            // Assign daily tasks
            foreach ($dailyTasks as $task) {
                // ... old code ...
            }

            // Assign weekly tasks
            foreach ($weeklyTasks as $task) {
                // ... old code ...
            }

            // Maybe assign challenge tasks
            if (rand(0, 2) === 0) { // One-third chance
                // ... old code ...
            }
            */
        }
    }
}
