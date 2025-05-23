<?php

namespace App\Filament\Resources\RecipeTemplateResource\Pages;

use App\Filament\Resources\RecipeTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecipeTemplate extends EditRecord
{
    protected static string $resource = RecipeTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
