<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;

    // We're using direct Livewire component rendering in the blade file
    // instead of the widget registration system to match the admin panel structure
    protected static string $view = 'filament.teacher.pages.dashboard';

    public function getTitle(): string
    {
        return 'Teacher Dashboard';
    }

    public function getSubheading(): ?string
    {
        return 'Manage your teaching activities and monitor student progress';
    }

    // Override these methods to return empty arrays to prevent automatic widget rendering
    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}
