<?php

namespace App\Filament\Teacher\Resources\TypingTestChallengeResource\Pages;

use App\Filament\Teacher\Resources\TypingTestChallengeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTypingTestChallenge extends CreateRecord
{
    protected static string $resource = TypingTestChallengeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        
        return $data;
    }
}
