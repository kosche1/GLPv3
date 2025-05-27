<?php

namespace App\Filament\Resources\BackupArchiveResource\Pages;

use App\Filament\Resources\BackupArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBackupArchive extends EditRecord
{
    protected static string $resource = BackupArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit Archive Record';
    }

    public function getHeading(): string
    {
        return 'Edit Archive Record: ' . $this->record->filename;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
