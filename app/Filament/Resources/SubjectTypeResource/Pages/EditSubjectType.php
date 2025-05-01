<?php

namespace App\Filament\Resources\SubjectTypeResource\Pages;

use App\Filament\Resources\SubjectTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubjectType extends EditRecord
{
    protected static string $resource = SubjectTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
