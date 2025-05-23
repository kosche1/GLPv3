<?php

namespace App\Filament\Resources\RecipeTemplateResource\Pages;

use App\Filament\Resources\RecipeTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecipeTemplates extends ListRecords
{
    protected static string $resource = RecipeTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
