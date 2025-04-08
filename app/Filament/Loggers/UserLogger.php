<?php

namespace App\Filament\Loggers;

use App\Models\User;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class UserLogger extends ResourceLogger
{
    protected static string $model = User::class;

    protected static array $logAttributes = [
        'name',
        'email',
        'bio',
        'skills',
        'avatar',
    ];

    protected static array $ignoreAttributes = [
        'password',
        'remember_token',
    ];

    protected static array $logNameToLabel = [
        'name' => 'Name',
        'email' => 'Email',
        'bio' => 'Biography',
        'skills' => 'Skills',
        'avatar' => 'Avatar',
    ];

    public static function getLabel(): string
    {
        return 'User';
    }
}
