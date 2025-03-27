<?php

namespace App\OpenFunctions;

use App\Models\Challenge;
use App\Models\Task;
use AssistantEngine\OpenFunctions\Core\Contracts\AbstractOpenFunction;
use AssistantEngine\OpenFunctions\Core\Helpers\FunctionDefinition;
use AssistantEngine\OpenFunctions\Core\Helpers\Parameter;
use AssistantEngine\OpenFunctions\Core\Models\Responses\TextResponseItem;
use Illuminate\Support\Facades\Log;

class ITChallengeFunction extends AbstractOpenFunction
{
    /**
     * Generate function definitions for the IT Challenge service.
     *
     * @return array
     */
    public function generateFunctionDefinitions(): array
    {
        $definitions = [];

        // Definition for listChallenges
        $defListChallenges = new FunctionDefinition(
            'listChallenges',
            'Lists all available IT challenges.'
        );
        $defListChallenges->addParameter(
            Parameter::boolean("active_only")
                ->description("Filter to show only currently active challenges.")
                ->required()
        );
        $definitions[] = $defListChallenges->createFunctionDescription();

        // Definition for getChallenge
        $defGetChallenge = new FunctionDefinition(
            'getChallenge',
            'Gets detailed information about a specific challenge.'
        );
        $defGetChallenge->addParameter(
            Parameter::number("challenge_id")
                ->description("The ID of the challenge to retrieve.")
                ->required()
        );
        $definitions[] = $defGetChallenge->createFunctionDescription();

        // Definition for getChallengeTasks
        $defGetChallengeTasks = new FunctionDefinition(
            'getChallengeTasks',
            'Gets all tasks associated with a specific challenge.'
        );
        $defGetChallengeTasks->addParameter(
            Parameter::number("challenge_id")
                ->description("The ID of the challenge to retrieve tasks for.")
                ->required()
        );
        $definitions[] = $defGetChallengeTasks->createFunctionDescription();

        // Definition for searchChallenges
        $defSearchChallenges = new FunctionDefinition(
            'searchChallenges',
            'Search for challenges by name, description, or tech category.'
        );
        $defSearchChallenges->addParameter(
            Parameter::string("keywords")
                ->description("Keywords to search for in challenge names and descriptions.")
                ->required()
        );
        $defSearchChallenges->addParameter(
            Parameter::string("tech_category")
                ->description("Filter by technology category (e.g., programming, networking, security, cloud).")
                ->required()
        );
        $defSearchChallenges->addParameter(
            Parameter::string("difficulty_level")
                ->description("Filter by difficulty level.")
                ->required()
        );
        $definitions[] = $defSearchChallenges->createFunctionDescription();

        return $definitions;
    }

    /**
     * Lists all available IT challenges.
     *
     * @param bool $active_only Filter to show only currently active challenges.
     * @return TextResponseItem
     */
    public function listChallenges(bool $active_only = false)
    {
        try {
            $query = Challenge::query();
            
            if ($active_only) {
                $query->where('is_active', true);
            }
            
            $challenges = $query->get();
            
            if ($challenges->isEmpty()) {
                return new TextResponseItem("No challenges found.");
            }
            
            $challengeList = [];
            foreach ($challenges as $challenge) {
                $challengeList[] = "ID: {$challenge->id}, Name: {$challenge->name}, Difficulty: {$challenge->difficulty_level}, Points: {$challenge->points_reward}";
            }
            
            return new TextResponseItem("Available challenges:\n" . implode("\n", $challengeList));
        } catch (\Exception $e) {
            Log::error('Error in listChallenges: ' . $e->getMessage());
            return new TextResponseItem("Error retrieving challenges: " . $e->getMessage());
        }
    }

    /**
     * Gets detailed information about a specific challenge.
     *
     * @param int $challenge_id The ID of the challenge to retrieve.
     * @return TextResponseItem
     */
    public function getChallenge(int $challenge_id)
    {
        try {
            $challenge = Challenge::find($challenge_id);
            
            if (!$challenge) {
                return new TextResponseItem("Challenge with ID {$challenge_id} not found.");
            }
            
            $active = $challenge->isCurrentlyActive() ? 'Yes' : 'No';
            $taskCount = $challenge->tasks->count();
            
            $details = [
                "ID: {$challenge->id}",
                "Name: {$challenge->name}",
                "Description: {$challenge->description}",
                "Difficulty: {$challenge->difficulty_level}",
                "Tech Category: {$challenge->tech_category}",
                "Programming Language: {$challenge->programming_language}",
                "Points Reward: {$challenge->points_reward}",
                "Start Date: {$challenge->start_date}",
                "End Date: {$challenge->end_date}",
                "Currently Active: {$active}",
                "Task Count: {$taskCount}",
                "Required Level: {$challenge->required_level}",
                "Max Participants: {$challenge->max_participants}"
            ];
            
            return new TextResponseItem("Challenge Details:\n" . implode("\n", $details));
        } catch (\Exception $e) {
            Log::error('Error in getChallenge: ' . $e->getMessage());
            return new TextResponseItem("Error retrieving challenge: " . $e->getMessage());
        }
    }

    /**
     * Gets all tasks associated with a specific challenge.
     *
     * @param int $challenge_id The ID of the challenge to retrieve tasks for.
     * @return TextResponseItem
     */
    public function getChallengeTasks(int $challenge_id)
    {
        try {
            $challenge = Challenge::find($challenge_id);
            
            if (!$challenge) {
                return new TextResponseItem("Challenge with ID {$challenge_id} not found.");
            }
            
            $tasks = $challenge->tasks()->orderBy('order')->get();
            
            if ($tasks->isEmpty()) {
                return new TextResponseItem("No tasks found for challenge '{$challenge->name}'.");
            }
            
            $taskList = ["Tasks for challenge '{$challenge->name}':"];
            foreach ($tasks as $task) {
                $taskList[] = "  Task ID: {$task->id}, Name: {$task->name}, Points: {$task->points_reward}, Type: {$task->type}";
            }
            
            return new TextResponseItem(implode("\n", $taskList));
        } catch (\Exception $e) {
            Log::error('Error in getChallengeTasks: ' . $e->getMessage());
            return new TextResponseItem("Error retrieving tasks: " . $e->getMessage());
        }
    }

    /**
     * Search for challenges by name, description, or tech category.
     *
     * @param string $keywords Keywords to search for in challenge names and descriptions.
     * @param string|null $tech_category Filter by technology category.
     * @param string|null $difficulty_level Filter by difficulty level.
     * @return TextResponseItem
     */
    public function searchChallenges(string $keywords, ?string $tech_category = null, ?string $difficulty_level = null)
    {
        try {
            $query = Challenge::query()
                ->where(function($q) use ($keywords) {
                    $q->where('name', 'like', "%{$keywords}%")
                      ->orWhere('description', 'like', "%{$keywords}%");
                });
            
            if ($tech_category) {
                $query->where('tech_category', $tech_category);
            }
            
            if ($difficulty_level) {
                $query->where('difficulty_level', $difficulty_level);
            }
            
            $challenges = $query->get();
            
            if ($challenges->isEmpty()) {
                return new TextResponseItem("No challenges found matching your search criteria.");
            }
            
            $challengeList = ["Search Results:"];
            foreach ($challenges as $challenge) {
                $active = $challenge->isCurrentlyActive() ? 'Active' : 'Inactive';
                $challengeList[] = "ID: {$challenge->id}, Name: {$challenge->name}, Difficulty: {$challenge->difficulty_level}, Category: {$challenge->tech_category}, Status: {$active}";
            }
            
            return new TextResponseItem(implode("\n", $challengeList));
        } catch (\Exception $e) {
            Log::error('Error in searchChallenges: ' . $e->getMessage());
            return new TextResponseItem("Error searching challenges: " . $e->getMessage());
        }
    }
} 