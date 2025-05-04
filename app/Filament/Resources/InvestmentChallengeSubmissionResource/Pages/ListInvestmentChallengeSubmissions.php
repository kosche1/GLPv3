<?php

namespace App\Filament\Resources\InvestmentChallengeSubmissionResource\Pages;

use App\Filament\Resources\InvestmentChallengeSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestmentChallengeSubmissions extends ListRecords
{
    protected static string $resource = InvestmentChallengeSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action needed as submissions are created by students
        ];
    }
}
