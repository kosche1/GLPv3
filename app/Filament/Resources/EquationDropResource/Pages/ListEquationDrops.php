<?php

namespace App\Filament\Resources\EquationDropResource\Pages;

use App\Filament\Resources\EquationDropResource;
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
