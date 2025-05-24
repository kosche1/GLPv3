<?php

namespace App\Filament\Teacher\Resources\TypingTestChallengeResource\Pages;

use App\Filament\Teacher\Resources\TypingTestChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTypingTestChallenge extends ViewRecord
{
    protected static string $resource = TypingTestChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
