<?php

namespace App\Filament\Loggers;

use App\Models\Challenge;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class ChallengeLogger extends ResourceLogger
{
    protected static string $model = Challenge::class;

    protected static array $logAttributes = [
        'name',
        'description',
        'start_date',
        'end_date',
        'points_reward',
        'difficulty_level',
        'is_active',
        'max_participants',
        'completion_criteria',
        'additional_rewards',
        'required_level',
        'category_id',
        'challenge_type',
        'time_limit',
        'programming_language',
        'tech_category',
        'image',
    ];

    protected static array $logNameToLabel = [
        'name' => 'Name',
        'description' => 'Description',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'points_reward' => 'Points Reward',
        'difficulty_level' => 'Difficulty Level',
        'is_active' => 'Is Active',
        'max_participants' => 'Max Participants',
        'completion_criteria' => 'Completion Criteria',
        'additional_rewards' => 'Additional Rewards',
        'required_level' => 'Required Level',
        'category_id' => 'Category',
        'challenge_type' => 'Challenge Type',
        'time_limit' => 'Time Limit',
        'programming_language' => 'Programming Language',
        'tech_category' => 'Tech Category',
        'image' => 'Image',
    ];

    public static function getLabel(): string
    {
        return 'Challenge';
    }
}
