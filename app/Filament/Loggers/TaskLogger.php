<?php

namespace App\Filament\Loggers;

use App\Models\Task;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class TaskLogger extends ResourceLogger
{
    protected static string $model = Task::class;

    protected static array $logAttributes = [
        'name',
        'title',
        'description',
        'instructions',
        'points_reward',
        'submission_type',
        'evaluation_type',
        'evaluation_details',
        'expected_output',
        'is_active',
        'due_date',
        'challenge_id',
        'order',
    ];

    protected static array $logNameToLabel = [
        'name' => 'Name',
        'title' => 'Title',
        'description' => 'Description',
        'instructions' => 'Instructions',
        'points_reward' => 'Points Reward',
        'submission_type' => 'Submission Type',
        'evaluation_type' => 'Evaluation Type',
        'evaluation_details' => 'Evaluation Details',
        'expected_output' => 'Expected Output',
        'is_active' => 'Is Active',
        'due_date' => 'Due Date',
        'challenge_id' => 'Challenge',
        'order' => 'Order',
    ];

    public static function getLabel(): string
    {
        return 'Task';
    }
}
