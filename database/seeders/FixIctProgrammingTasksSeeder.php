<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;
use App\Models\Task;

class FixIctProgrammingTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the Python Programming challenge
        $pythonChallenge = Challenge::where('name', 'Python Programming')
            ->where('tech_category', 'ict')
            ->first();

        if ($pythonChallenge) {
            // Update the challenge content to remove the Hello World example
            $pythonChallenge->challenge_content = [
                'scenario' => 'Practice Python programming with these beginner-friendly exercises',
            ];
            $pythonChallenge->save();

            // The tasks are already good, no need to update them
            $this->command->info('Python Programming challenge updated successfully.');
        } else {
            $this->command->error('Python Programming challenge not found.');
        }

        // Find the JavaScript Programming challenge
        $jsChallenge = Challenge::where('name', 'JavaScript Programming')
            ->where('tech_category', 'ict')
            ->first();

        if ($jsChallenge) {
            // Update the challenge content to remove the Hello World example
            $jsChallenge->challenge_content = [
                'scenario' => 'Practice JavaScript programming with these beginner-friendly exercises',
            ];
            $jsChallenge->save();

            // Find all tasks for this challenge
            $tasks = Task::where('challenge_id', $jsChallenge->id)->get();
            
            // If there are tasks, update them
            if ($tasks->count() > 0) {
                foreach ($tasks as $task) {
                    // Make sure the evaluation type is manual
                    $task->evaluation_type = 'manual';
                    $task->save();
                }
                $this->command->info('JavaScript Programming tasks updated successfully.');
            } else {
                $this->command->error('No JavaScript Programming tasks found.');
            }
        } else {
            $this->command->error('JavaScript Programming challenge not found.');
        }

        // Find the Java Programming challenge
        $javaChallenge = Challenge::where('name', 'Java Programming')
            ->where('tech_category', 'ict')
            ->first();

        if ($javaChallenge) {
            // Update the challenge content to remove the Hello World example
            $javaChallenge->challenge_content = [
                'scenario' => 'Practice Java programming with these beginner-friendly exercises',
            ];
            $javaChallenge->save();

            // Find all tasks for this challenge
            $tasks = Task::where('challenge_id', $javaChallenge->id)->get();
            
            // If there are tasks, update them
            if ($tasks->count() > 0) {
                foreach ($tasks as $task) {
                    // Make sure the evaluation type is manual
                    $task->evaluation_type = 'manual';
                    $task->save();
                }
                $this->command->info('Java Programming tasks updated successfully.');
            } else {
                $this->command->error('No Java Programming tasks found.');
            }
        } else {
            $this->command->error('Java Programming challenge not found.');
        }
    }
}
