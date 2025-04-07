<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Challenge;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class StudentAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Student Analytics';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Teaching';

    protected static string $view = 'filament.teacher.pages.student-analytics';

    public function getTitle(): string
    {
        return 'Student Analytics';
    }

    public function getSubheading(): ?string
    {
        return 'Track student performance and progress metrics';
    }
}
