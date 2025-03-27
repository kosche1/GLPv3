<?php

namespace App\OpenFunctions;

use App\Models\Challenge;
use App\Models\Task;
use AssistantEngine\OpenFunctions\Core\Contracts\AbstractOpenFunction;
use AssistantEngine\OpenFunctions\Core\Helpers\FunctionDefinition;
use AssistantEngine\OpenFunctions\Core\Helpers\Parameter;
use AssistantEngine\OpenFunctions\Core\Models\Responses\TextResponseItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ChallengeCreatorFunction extends AbstractOpenFunction
{
    /**
     * Generate function definitions for the Challenge Creator service.
     *
     * @return array
     */
    public function generateFunctionDefinitions(): array
    {
        $definitions = [];

        // Definition for createChallenge
        $defCreateChallenge = new FunctionDefinition(
            'createChallenge',
            'Creates a new IT challenge based on topic and requirements.'
        );
        $defCreateChallenge->addParameter(
            Parameter::string("name")
                ->description("Name of the challenge.")
                ->required()
        );
        $defCreateChallenge->addParameter(
            Parameter::string("description")
                ->description("Detailed description of the challenge.")
                ->required()
        );
        $defCreateChallenge->addParameter(
            Parameter::string("challenge_type")
                ->description("Type of challenge: debugging, algorithm, database, or ui_design.")
                ->required()
        );
        $defCreateChallenge->addParameter(
            Parameter::string("difficulty_level")
                ->description("Difficulty level: beginner, intermediate, advanced, or expert.")
                ->required()
        );
        $defCreateChallenge->addParameter(
            Parameter::string("programming_language")
                ->description("Primary programming language for the challenge: python, java, csharp, php, sql, or none.")
                ->required()
        );
        $defCreateChallenge->addParameter(
            Parameter::number("points_reward")
                ->description("Points awarded for completing the challenge.")
                ->required()
        );
        $defCreateChallenge->addParameter(
            Parameter::number("time_limit")
                ->description("Time limit in minutes (leave 0 for no limit).")
                ->required()
        );
        $defCreateChallenge->addParameter(
            Parameter::object("challenge_content")
                ->description("Specific content for the challenge based on its type.")
                ->required()
        );
        $definitions[] = $defCreateChallenge->createFunctionDescription();

        // Definition for addTaskToChallenge
        $defAddTask = new FunctionDefinition(
            'addTaskToChallenge',
            'Adds a new task to an existing challenge.'
        );
        $defAddTask->addParameter(
            Parameter::number("challenge_id")
                ->description("ID of the challenge to add the task to.")
                ->required()
        );
        $defAddTask->addParameter(
            Parameter::string("name")
                ->description("Name of the task.")
                ->required()
        );
        $defAddTask->addParameter(
            Parameter::string("description")
                ->description("Detailed description of the task.")
                ->required()
        );
        $defAddTask->addParameter(
            Parameter::number("points_reward")
                ->description("Points awarded for completing the task.")
                ->required()
        );
        $defAddTask->addParameter(
            Parameter::string("type")
                ->description("Type of task: daily, weekly, onetime, repeatable, or challenge.")
                ->required()
        );
        $defAddTask->addParameter(
            Parameter::object("answer_key")
                ->description("The correct answers or solutions for the task.")
                ->required()
        );
        $defAddTask->addParameter(
            Parameter::number("order")
                ->description("Order of the task within the challenge.")
                ->required()
        );
        $definitions[] = $defAddTask->createFunctionDescription();

        return $definitions;
    }

    /**
     * Creates a new IT challenge based on topic and requirements.
     *
     * @param string $name Name of the challenge
     * @param string $description Detailed description of the challenge
     * @param string $challenge_type Type of challenge
     * @param string $difficulty_level Difficulty level
     * @param string $programming_language Primary programming language
     * @param int $points_reward Points awarded
     * @param int $time_limit Time limit in minutes
     * @param array $challenge_content Specific content for the challenge
     * @return TextResponseItem
     */
    public function createChallenge(
        string $name, 
        string $description, 
        string $challenge_type, 
        string $difficulty_level,
        string $programming_language, 
        int $points_reward, 
        int $time_limit,
        array $challenge_content
    ) {
        try {
            // Validate challenge type
            $validTypes = ['debugging', 'algorithm', 'database', 'ui_design'];
            if (!in_array($challenge_type, $validTypes)) {
                return new TextResponseItem("Invalid challenge type. Must be one of: " . implode(", ", $validTypes));
            }

            // Validate difficulty level
            $validDifficulties = ['beginner', 'intermediate', 'advanced', 'expert'];
            if (!in_array($difficulty_level, $validDifficulties)) {
                return new TextResponseItem("Invalid difficulty level. Must be one of: " . implode(", ", $validDifficulties));
            }

            // Validate programming language
            $validLanguages = ['python', 'java', 'csharp', 'php', 'sql', 'none'];
            if (!in_array($programming_language, $validLanguages)) {
                return new TextResponseItem("Invalid programming language. Must be one of: " . implode(", ", $validLanguages));
            }

            // Create the challenge
            $challenge = Challenge::create([
                'name' => $name,
                'description' => $description,
                'challenge_type' => $challenge_type,
                'difficulty_level' => $difficulty_level,
                'programming_language' => $programming_language,
                'points_reward' => $points_reward,
                'time_limit' => $time_limit > 0 ? $time_limit : null,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30), // Default 30 days duration
                'challenge_content' => $challenge_content,
            ]);

            return new TextResponseItem("Challenge created successfully! Challenge ID: {$challenge->id}\n" .
                "Name: {$challenge->name}\n" .
                "Type: {$challenge->challenge_type}\n" .
                "Difficulty: {$challenge->difficulty_level}\n" .
                "Points: {$challenge->points_reward}\n" .
                "Now you can add tasks to this challenge using the addTaskToChallenge function.");
                
        } catch (\Exception $e) {
            Log::error('Error in createChallenge: ' . $e->getMessage());
            return new TextResponseItem("Error creating challenge: " . $e->getMessage());
        }
    }

    /**
     * Adds a new task to an existing challenge.
     *
     * @param int $challenge_id ID of the challenge
     * @param string $name Name of the task
     * @param string $description Description of the task
     * @param int $points_reward Points awarded
     * @param string $type Type of task
     * @param array $answer_key Correct answers or solution
     * @param int $order Order within the challenge
     * @return TextResponseItem
     */
    public function addTaskToChallenge(
        int $challenge_id,
        string $name,
        string $description,
        int $points_reward,
        string $type,
        array $answer_key,
        int $order = 1
    ) {
        try {
            // Find the challenge
            $challenge = Challenge::find($challenge_id);
            if (!$challenge) {
                return new TextResponseItem("Challenge with ID {$challenge_id} not found.");
            }

            // Validate task type
            $validTypes = ['daily', 'weekly', 'onetime', 'repeatable', 'challenge'];
            if (!in_array($type, $validTypes)) {
                return new TextResponseItem("Invalid task type. Must be one of: " . implode(", ", $validTypes));
            }

            // Create the task
            $task = Task::create([
                'name' => $name,
                'description' => $description,
                'points_reward' => $points_reward,
                'type' => $type,
                'is_active' => true,
                'challenge_id' => $challenge_id,
                'answer_key' => $answer_key,
                'order' => $order,
            ]);

            return new TextResponseItem("Task added successfully to challenge '{$challenge->name}'!\n" .
                "Task ID: {$task->id}\n" .
                "Name: {$task->name}\n" .
                "Points: {$task->points_reward}");
                
        } catch (\Exception $e) {
            Log::error('Error in addTaskToChallenge: ' . $e->getMessage());
            return new TextResponseItem("Error adding task to challenge: " . $e->getMessage());
        }
    }
} 