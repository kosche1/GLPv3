<?php

namespace App\Filament\Loggers;

use App\Models\LearningMaterial;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class LearningMaterialLogger extends ResourceLogger
{
    protected static string $model = LearningMaterial::class;

    protected static array $logAttributes = [
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'created_by',
        'is_published',
        'published_at',
    ];

    protected static array $logNameToLabel = [
        'title' => 'Title',
        'description' => 'Description',
        'file_path' => 'File Path',
        'file_name' => 'File Name',
        'file_type' => 'File Type',
        'file_size' => 'File Size',
        'created_by' => 'Created By',
        'is_published' => 'Is Published',
        'published_at' => 'Published At',
    ];

    public static function getLabel(): string
    {
        return 'Learning Material';
    }
}
