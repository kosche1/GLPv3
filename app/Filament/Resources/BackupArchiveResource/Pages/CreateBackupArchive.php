<?php

namespace App\Filament\Resources\BackupArchiveResource\Pages;

use App\Filament\Resources\BackupArchiveResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBackupArchive extends CreateRecord
{
    protected static string $resource = BackupArchiveResource::class;

    public function getTitle(): string
    {
        return 'Add Archive Record';
    }

    public function getHeading(): string
    {
        return 'Add Archive Record';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['archived_by'] = auth()->id();
        $data['archived_date'] = now();
        
        return $data;
    }
}
