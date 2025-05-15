<?php

namespace App\Filament\Resources\HistoricalTimelineMazeResource\Pages;

use App\Filament\Resources\HistoricalTimelineMazeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHistoricalTimelineMazes extends ListRecords
{
    protected static string $resource = HistoricalTimelineMazeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
