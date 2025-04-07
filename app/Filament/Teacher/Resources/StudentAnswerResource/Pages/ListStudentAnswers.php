<?php

namespace App\Filament\Teacher\Resources\StudentAnswerResource\Pages;

use App\Filament\Teacher\Resources\StudentAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListStudentAnswers extends ListRecords
{
    protected static string $resource = StudentAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action needed for student answers
        ];
    }
    
    // Override the table query to filter by status if provided
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        
        // Check if status is provided in the URL
        $status = request()->query('status');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query;
    }
}
