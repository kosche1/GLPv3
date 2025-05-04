<?php

namespace App\Filament\Teacher\Resources\InvestSmartChallengeResource\Pages;

use App\Filament\Teacher\Resources\InvestSmartChallengeResource;
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
