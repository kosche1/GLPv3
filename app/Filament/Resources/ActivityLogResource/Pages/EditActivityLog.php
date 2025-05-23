<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActivityLog extends EditRecord
{
    protected static string $resource = ActivityLogResource::class;

    public function getTitle(): string
    {
        return 'Edit Audit Trail Record';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
}
