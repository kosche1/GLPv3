<?php

namespace App\Filament\Resources\TypingTestChallengeResource\Pages;

use App\Filament\Resources\TypingTestChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypingTestChallenge extends EditRecord
{
    protected static string $resource = TypingTestChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
