<?php

namespace App\Filament\Teacher\Resources\TypingTestResultResource\Pages;

use App\Filament\Teacher\Resources\TypingTestResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypingTestResult extends EditRecord
{
    protected static string $resource = TypingTestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
