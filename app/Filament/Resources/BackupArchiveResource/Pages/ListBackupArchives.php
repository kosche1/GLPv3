<?php

namespace App\Filament\Resources\BackupArchiveResource\Pages;

use App\Filament\Resources\BackupArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBackupArchives extends ListRecords
{
    protected static string $resource = BackupArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Archive Record')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTitle(): string
    {
        return 'Database Archives';
    }

    public function getHeading(): string
    {
        return 'Database Archives';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // You can add widgets here if needed
        ];
    }
}
