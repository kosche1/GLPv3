<?php

namespace App\Filament\Resources\DailyRewardTierResource\Pages;

use App\Filament\Resources\DailyRewardTierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyRewardTier extends EditRecord
{
    protected static string $resource = DailyRewardTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
