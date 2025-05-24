<?php

namespace App\Filament\Resources\TypingTestChallengeResource\Pages;

use App\Filament\Resources\TypingTestChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypingTestChallenges extends ListRecords
{
    protected static string $resource = TypingTestChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
