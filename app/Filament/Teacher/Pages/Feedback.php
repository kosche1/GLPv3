<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;

class Feedback extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Feedback';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Teaching';

    protected static string $view = 'filament.teacher.pages.feedback';
}