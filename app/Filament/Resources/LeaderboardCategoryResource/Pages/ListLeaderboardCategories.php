<?php

namespace App\Filament\Resources\LeaderboardCategoryResource\Pages;

use App\Filament\Resources\LeaderboardCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaderboardCategories extends ListRecords
{
    protected static string $resource = LeaderboardCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
