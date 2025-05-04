<?php

namespace App\Filament\Resources\UserRecipeResource\Pages;

use App\Filament\Resources\UserRecipeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserRecipe extends CreateRecord
{
    protected static string $resource = UserRecipeResource::class;
    
    // Redirect to list page after creation
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
