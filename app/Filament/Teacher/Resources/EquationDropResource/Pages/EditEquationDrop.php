<?php

namespace App\Filament\Teacher\Resources\EquationDropResource\Pages;

use App\Filament\Teacher\Resources\EquationDropResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquationDrop extends EditRecord
{
    protected static string $resource = EquationDropResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
