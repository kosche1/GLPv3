<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Str;

class Feedback extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Communication';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Teaching';

    protected static string $view = 'filament.teacher.pages.feedback';

    public function getTitle(): string
    {
        return 'Communication & Feedback';
    }

    public function getSubheading(): ?string
    {
        return 'Manage communication with students and provide feedback on their work';
    }
}