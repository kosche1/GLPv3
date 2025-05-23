<?php

namespace App\Filament\Teacher\Resources\RecipeTemplateResource\Pages;

use App\Filament\Teacher\Resources\RecipeTemplateResource;
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
