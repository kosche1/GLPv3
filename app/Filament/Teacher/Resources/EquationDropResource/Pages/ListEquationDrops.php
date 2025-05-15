<?php

namespace App\Filament\Teacher\Resources\EquationDropResource\Pages;

use App\Filament\Teacher\Resources\EquationDropResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquationDrops extends ListRecords
{
    protected static string $resource = EquationDropResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
