<?php

namespace App\Filament\Resources\StrandResource\Pages;

use App\Filament\Resources\StrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStrand extends EditRecord
{
    protected static string $resource = StrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
