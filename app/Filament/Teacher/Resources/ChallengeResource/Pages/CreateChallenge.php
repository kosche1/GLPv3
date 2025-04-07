<?php

namespace App\Filament\Teacher\Resources\ChallengeResource\Pages;

use App\Filament\Teacher\Resources\ChallengeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChallenge extends CreateRecord
{
    protected static string $resource = ChallengeResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
