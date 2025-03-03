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
        $oneTimeTasks = $tasks->where('type', 'onetime');
        $dailyTasks = $tasks->where('type', 'daily');
        $weeklyTasks = $tasks->where('type', 'weekly');
        $challengeTasks = $tasks->where('type', 'challenge');

        foreach ($users as $user) {
            // Assign one-time tasks (some completed, some in progress)
            foreach ($oneTimeTasks as $task) {
                $completed = rand(0, 1) === 1;
                $progress = $completed ? 100 : rand(0, 99);
                $completedAt = $completed ? now()->subDays(rand(1, 14)) : null;
                $rewardClaimed = $completed && rand(0, 1) === 1;

                DB::table('user_tasks')->insert([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                    'progress' => $progress,
                    'completed' => $completed,
                    'completed_at' => $completedAt,
                    'reward_claimed' => $rewardClaimed,
                    'reward_claimed_at' => $rewardClaimed ? $completedAt->addMinutes(rand(1, 60)) : null,
                    'created_at' => now()->subDays(rand(15, 30)),
                    'updated_at' => now(),
                ]);
            }

            // Assign daily tasks
            foreach ($dailyTasks as $task) {
                $completed = rand(0, 1) === 1;

                DB::table('user_tasks')->insert([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                    'progress' => $completed ? 100 : rand(0, 99),
                    'completed' => $completed,
                    'completed_at' => $completed ? now()->subHours(rand(1, 12)) : null,
                    'reward_claimed' => $completed,
                    'reward_claimed_at' => $completed ? now()->subHours(rand(1, 11)) : null,
                    'created_at' => now()->startOfDay(),
                    'updated_at' => now(),
                ]);
            }

            // Assign weekly tasks
            foreach ($weeklyTasks as $task) {
                $progress = rand(0, 100);
                $completed = $progress === 100;

                DB::table('user_tasks')->insert([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                    'progress' => $progress,
                    'completed' => $completed,
                    'completed_at' => $completed ? now()->subDays(rand(1, 5)) : null,
                    'reward_claimed' => $completed && rand(0, 1) === 1,
                    'reward_claimed_at' => $completed && rand(0, 1) === 1 ? now()->subDays(rand(1, 4)) : null,
                    'created_at' => now()->startOfWeek(),
                    'updated_at' => now(),
                ]);
            }

            // Maybe assign challenge tasks
            if (rand(0, 2) === 0) { // One-third chance
                $task = $challengeTasks->random();
                $progress = rand(0, 80); // Challenges are harder to complete

                DB::table('user_tasks')->insert([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                    'progress' => $progress,
                    'completed' => false, // Most users haven't completed challenges
                    'completed_at' => null,
                    'reward_claimed' => false,
                    'reward_claimed_at' => null,
                    'created_at' => now()->subDays(rand(5, 20)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
