<?php

namespace App\Filament\Teacher\Resources\InvestSmartResultResource\Pages;

use App\Filament\Teacher\Resources\InvestSmartResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestSmartResults extends ListRecords
{
    protected static string $resource = InvestSmartResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action needed as results are generated by students
        ];
    }
}
