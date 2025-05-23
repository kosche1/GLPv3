<?php

namespace App\Filament\Resources\RecipeTemplateResource\Pages;

use App\Filament\Resources\RecipeTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRecipeTemplate extends ViewRecord
{
    protected static string $resource = RecipeTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
