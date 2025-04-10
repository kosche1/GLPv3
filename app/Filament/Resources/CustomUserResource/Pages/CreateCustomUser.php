<?php

namespace App\Filament\Resources\CustomUserResource\Pages;

use App\Filament\Resources\CustomUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

class CreateCustomUser extends CreateRecord
{
    protected static string $resource = CustomUserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If no roles are selected, assign the student role by default
        if (empty($data['roles'])) {
            $studentRole = Role::where('name', 'student')->first();
            if ($studentRole) {
                $data['roles'] = [$studentRole->id];
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
