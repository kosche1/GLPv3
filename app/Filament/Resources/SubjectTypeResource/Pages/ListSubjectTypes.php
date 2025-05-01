<?php

namespace App\Filament\Resources\SubjectTypeResource\Pages;

use App\Filament\Resources\SubjectTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubjectTypes extends ListRecords
{
    protected static string $resource = SubjectTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
