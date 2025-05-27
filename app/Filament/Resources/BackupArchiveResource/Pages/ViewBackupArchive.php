<?php

namespace App\Filament\Resources\BackupArchiveResource\Pages;

use App\Filament\Resources\BackupArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBackupArchive extends ViewRecord
{
    protected static string $resource = BackupArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'View Archive Record';
    }

    public function getHeading(): string
    {
        return 'Archive Record: ' . $this->record->filename;
    }
}
