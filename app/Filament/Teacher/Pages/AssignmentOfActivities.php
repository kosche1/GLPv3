<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;

class AssignmentOfActivities extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationLabel = 'Assignment of Activities';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Teaching';

    protected static string $view = 'filament.teacher.pages.assignment-of-activities';
}