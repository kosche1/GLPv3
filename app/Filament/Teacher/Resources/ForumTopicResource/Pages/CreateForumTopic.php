<?php

namespace App\Filament\Teacher\Resources\ForumTopicResource\Pages;

use App\Filament\Teacher\Resources\ForumTopicResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumTopic extends CreateRecord
{
    protected static string $resource = ForumTopicResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
