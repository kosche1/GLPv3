<?php

namespace App\Filament\Resources\InvestSmartChallengeResource\Pages;

use App\Filament\Resources\InvestSmartChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInvestSmartChallenge extends ViewRecord
{
    protected static string $resource = InvestSmartChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
