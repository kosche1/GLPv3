<?php

namespace App\OpenFunctions;

use App\Models\Challenge;
use App\Models\Task;
use AssistantEngine\OpenFunctions\Core\Contracts\AbstractOpenFunction;
use AssistantEngine\OpenFunctions\Core\Models\Responses\TextResponseItem;
use AssistantEngine\OpenFunctions\Core\Helpers\FunctionDefinition;
use AssistantEngine\OpenFunctions\Core\Helpers\Parameter;

class ChallengeManagementFunction extends AbstractOpenFunction
{
    /**
     * Generate function definitions for challenge management.
     */
    public function generateFunctionDefinitions(): array
    {
        $createChallenge = new FunctionDefinition(
            'createChallenge',
            'Creates a new challenge with optional tasks'
        );

        $createChallenge->addParameter(
            Parameter::string('name')
                ->description('Name of the challenge')
                ->required()
        );
        
        $createChallenge->addParameter(
            Parameter::string('description')
                ->description('Description of the challenge')
                ->required()
        );

        $createChallenge->addParameter(
            Parameter::string('challenge_type')
                ->description('Type of challenge (debugging, algorithm, database, ui_design)')
                ->required()
        );

        $createChallenge->addParameter(
            Parameter::string('difficulty_level')
                ->description('Difficulty level (beginner, intermediate, advanced, expert)')
                ->required()
        );

        $createChallenge->addParameter(
            Parameter::integer('points_reward')
                ->description('Points awarded for completing the challenge')
                ->required()
        );

        $createChallenge->addParameter(
            Parameter::array('tasks')
                ->description('Array of tasks for the challenge')
                ->items(
                    Parameter::object()
                        ->properties([
                            'name' => Parameter::string()->required(),
                            'description' => Parameter::string()->required(),
                            'points_reward' => Parameter::integer()->required(),
                            'type' => Parameter::string()->required(),
                            'completion_criteria' => Parameter::object(),
                            'answer_key' => Parameter::object()
                        ])
                )
        );

        $createTask = new FunctionDefinition(
            'createTask',
            'Creates a new task for an existing challenge'
        );

        $createTask->addParameter(
            Parameter::integer('challenge_id')
                ->description('ID of the challenge to attach the task to')
                ->required()
        );

        $createTask->addParameter(
            Parameter::string('name')
                ->description('Name of the task')
                ->required()
        );

        $createTask->addParameter(
            Parameter::string('description')
                ->description('Description of the task')
                ->required()
        );

        $createTask->addParameter(
            Parameter::integer('points_reward')
                ->description('Points awarded for completing the task')
                ->required()
        );

        $createTask->addParameter(
            Parameter::string('type')
                ->description('Type of task (daily, weekly, onetime, repeatable, challenge)')
                ->required()
        );

        return [
            $createChallenge->createFunctionDescription(),
            $createTask->createFunctionDescription()
        ];
    }

    /**
     * Create a new challenge with optional tasks
     */
    public function createChallenge(
        string $name,
        string $description,
        string $challenge_type,
        string $difficulty_level,
        int $points_reward,
        ?array $tasks = []
    ): TextResponseItem {
        $challenge = Challenge::create([
            'name' => $name,
            'description' => $description,
            'challenge_type' => $challenge_type,
            'difficulty_level' => $difficulty_level,
            'points_reward' => $points_reward,
            'is_active' => true,
            'start_date' => now(),
        ]);

        if (!empty($tasks)) {
            foreach ($tasks as $taskData) {
                Task::create([
                    'name' => $taskData['name'],
                    'description' => $taskData['description'],
                    'points_reward' => $taskData['points_reward'],
                    'type' => $taskData['type'],
                    'completion_criteria' => $taskData['completion_criteria'] ?? [],
                    'answer_key' => $taskData['answer_key'] ?? [],
                    'challenge_id' => $challenge->id,
                    'is_active' => true,
                ]);
            }
        }

        return new TextResponseItem("Challenge '{$name}' created successfully with ID: {$challenge->id}");
    }

    /**
     * Create a new task for an existing challenge
     */
    public function createTask(
        int $challenge_id,
        string $name,
        string $description,
        int $points_reward,
        string $type,
        ?array $completion_criteria = [],
        ?array $answer_key = []
    ): TextResponseItem {
        $challenge = Challenge::find($challenge_id);
        
        if (!$challenge) {
            return new TextResponseItem("Error: Challenge with ID {$challenge_id} not found");
        }

        $task = Task::create([
            'name' => $name,
            'description' => $description,
            'points_reward' => $points_reward,
            'type' => $type,
            'completion_criteria' => $completion_criteria,
            'answer_key' => $answer_key,
            'challenge_id' => $challenge_id,
            'is_active' => true,
        ]);

        return new TextResponseItem("Task '{$name}' created successfully and attached to challenge '{$challenge->name}'");
    }
} 