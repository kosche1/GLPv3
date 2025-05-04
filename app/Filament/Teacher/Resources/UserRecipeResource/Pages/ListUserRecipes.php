<?php

namespace App\Filament\Teacher\Resources\UserRecipeResource\Pages;

use App\Filament\Teacher\Resources\UserRecipeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserRecipes extends ListRecords
{
    protected static string $resource = UserRecipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action needed as recipes are created by students
        ];
    }
}
