<?php

namespace App\Filament\Resources\DailyRewardTierResource\Pages;

use App\Filament\Resources\DailyRewardTierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyRewardTiers extends ListRecords
{
    protected static string $resource = DailyRewardTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
