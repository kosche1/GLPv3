<?php

namespace App\Filament\Loggers;

use App\Models\StudentAnswer;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class StudentAnswerLogger extends ResourceLogger
{
    protected static string $model = StudentAnswer::class;

    protected static array $logAttributes = [
        'user_id',
        'task_id',
        'output',
        'status',
        'is_correct',
        'score',
        'submitted_text',
        'submitted_file_path',
        'submitted_url',
        'submitted_data',
        'feedback',
        'evaluated_at',
        'evaluated_by',
    ];

    protected static array $logNameToLabel = [
        'user_id' => 'User',
        'task_id' => 'Task',
        'output' => 'Output',
        'status' => 'Status',
        'is_correct' => 'Is Correct',
        'score' => 'Score',
        'submitted_text' => 'Submitted Text',
        'submitted_file_path' => 'Submitted File Path',
        'submitted_url' => 'Submitted URL',
        'submitted_data' => 'Submitted Data',
        'feedback' => 'Feedback',
        'evaluated_at' => 'Evaluated At',
        'evaluated_by' => 'Evaluated By',
    ];

    public static function getLabel(): string
    {
        return 'Student Answer';
    }
}
