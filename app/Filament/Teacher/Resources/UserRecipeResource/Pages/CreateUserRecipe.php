<?php

namespace App\Filament\Teacher\Resources\UserRecipeResource\Pages;

use App\Filament\Teacher\Resources\UserRecipeResource;
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
