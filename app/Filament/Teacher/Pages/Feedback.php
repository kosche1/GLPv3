<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;

// This class is no longer used as the Communication section has been removed
// Forum functionality is now directly accessible from the Teaching navigation group
class Feedback extends Page
{
    // Hide this page from navigation
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Communication (Deprecated)';
    protected static ?int $navigationSort = 99;
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