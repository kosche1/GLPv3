<?php

namespace App\Filament\Teacher\Resources\ForumTopicResource\Pages;

use App\Filament\Teacher\Resources\ForumTopicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForumTopic extends EditRecord
{
    protected static string $resource = ForumTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
