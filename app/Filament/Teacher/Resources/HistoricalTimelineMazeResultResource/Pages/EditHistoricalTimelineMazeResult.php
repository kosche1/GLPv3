<?php

namespace App\Filament\Teacher\Resources\HistoricalTimelineMazeResultResource\Pages;

use App\Filament\Teacher\Resources\HistoricalTimelineMazeResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistoricalTimelineMazeResult extends EditRecord
{
    protected static string $resource = HistoricalTimelineMazeResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
