<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Teacher\Widgets\StudentStats;
use App\Filament\Teacher\Widgets\RecentActivities;
use App\Filament\Teacher\Widgets\UpcomingTasks;
use App\Filament\Teacher\Widgets\TopStudents;
use App\Filament\Teacher\Widgets\ChallengeCompletion;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            StudentStats::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RecentActivities::class,
            UpcomingTasks::class,
            TopStudents::class,
            ChallengeCompletion::class,
        ];
    }

    public function getTitle(): string
    {
        return 'Teacher Dashboard';
    }

    public function getSubheading(): ?string
    {
        return 'Manage your teaching activities and monitor student progress';
    }
}
