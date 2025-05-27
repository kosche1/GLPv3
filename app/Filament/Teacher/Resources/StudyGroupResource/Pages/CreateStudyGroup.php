<?php

namespace App\Filament\Teacher\Resources\StudyGroupResource\Pages;

use App\Filament\Teacher\Resources\StudyGroupResource;
use App\Models\StudyGroup;
use Filament\Resources\Pages\CreateRecord;

class CreateStudyGroup extends CreateRecord
{
    protected static string $resource = StudyGroupResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the creator to the current user
        $data['created_by'] = auth()->id();

        // Generate join code for private groups if not provided
        if ($data['is_private'] && empty($data['join_code'])) {
            $data['join_code'] = StudyGroup::generateJoinCode();
        }

        // Remove join code for public groups
        if (!$data['is_private']) {
            $data['join_code'] = null;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Add the creator as a leader of the group
        $this->record->members()->attach(auth()->id(), [
            'role' => 'leader',
            'joined_at' => now(),
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
