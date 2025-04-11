<?php

namespace App\Filament\Pages;

use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;
use Filament\Actions\Action;

class Backups extends BaseBackups
{
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public function getHeading(): string
    {
        return 'Database Backups';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getNavigationLabel(): string
    {
        return 'Backups';
    }

    public static function getNavigationSort(): ?int
    {
        return 10;
    }

    protected function getCreateAction(): Action
    {
        return parent::getCreateAction()
            ->label('Create Backup')
            ->icon('heroicon-o-plus')
            ->color('primary');
    }
}
