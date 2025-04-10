<?php

namespace App\Filament\Resources\CustomUserResource\Pages;

use App\Filament\Resources\CustomUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomUser extends EditRecord
{
    protected static string $resource = CustomUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
