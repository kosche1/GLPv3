<?php

namespace App\Filament\Resources\UserRecipeResource\Pages;

use App\Filament\Resources\UserRecipeResource;
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
