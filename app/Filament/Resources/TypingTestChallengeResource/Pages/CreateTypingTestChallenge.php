<?php

namespace App\Filament\Resources\TypingTestChallengeResource\Pages;

use App\Filament\Resources\TypingTestChallengeResource;
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
