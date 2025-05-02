<?php

namespace App\Filament\Resources\StrandResource\Pages;

use App\Filament\Resources\StrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStrands extends ListRecords
{
    protected static string $resource = StrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
