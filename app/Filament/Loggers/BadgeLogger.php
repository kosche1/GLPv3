<?php

namespace App\Filament\Loggers;

use App\Models\Badge;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class BadgeLogger extends ResourceLogger
{
    protected static string $model = Badge::class;

    protected static array $logAttributes = [
        'name',
        'description',
        'image',
        'trigger_type',
        'trigger_conditions',
        'rarity_level',
        'is_hidden',
    ];

    protected static array $logNameToLabel = [
        'name' => 'Name',
        'description' => 'Description',
        'image' => 'Image',
        'trigger_type' => 'Trigger Type',
        'trigger_conditions' => 'Trigger Conditions',
        'rarity_level' => 'Rarity Level',
        'is_hidden' => 'Is Hidden',
    ];

    public static function getLabel(): string
    {
        return 'Badge';
    }
}
