<?php

namespace App\Filament\Teacher\Resources\HistoricalTimelineMazeResource\Pages;

use App\Filament\Teacher\Resources\HistoricalTimelineMazeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistoricalTimelineMaze extends EditRecord
{
    protected static string $resource = HistoricalTimelineMazeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
