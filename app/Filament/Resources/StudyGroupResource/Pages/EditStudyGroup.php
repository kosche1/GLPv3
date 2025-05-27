<?php

namespace App\Filament\Resources\StudyGroupResource\Pages;

use App\Filament\Resources\StudyGroupResource;
use App\Models\StudyGroup;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudyGroup extends EditRecord
{
    protected static string $resource = StudyGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('view_frontend')
                ->label('View on Frontend')
                ->icon('heroicon-o-eye')
                ->url(fn () => route('study-groups.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
