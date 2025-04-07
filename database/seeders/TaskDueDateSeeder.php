<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskDueDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tasks
        $tasks = Task::all();

        foreach ($tasks as $task) {
            // Set a random due date between today and 30 days from now
            $dueDate = Carbon::now()->addDays(rand(1, 30));
            
            // If the task doesn't have a title, use the name
            if (empty($task->title)) {
                $task->title = $task->name;
            }
            
            $task->due_date = $dueDate;
            $task->save();
        }
    }
}
