<?php

namespace App\Filament\Resources\InvestSmartChallengeResource\Pages;

use App\Filament\Resources\InvestSmartChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvestSmartChallenge extends EditRecord
{
    protected static string $resource = InvestSmartChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
}
