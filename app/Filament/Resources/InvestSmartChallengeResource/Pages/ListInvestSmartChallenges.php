<?php

namespace App\Filament\Resources\InvestSmartChallengeResource\Pages;

use App\Filament\Resources\InvestSmartChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestSmartChallenges extends ListRecords
{
    protected static string $resource = InvestSmartChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
