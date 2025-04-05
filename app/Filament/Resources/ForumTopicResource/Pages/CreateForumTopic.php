<?php

namespace App\Filament\Resources\ForumTopicResource\Pages;

use App\Filament\Resources\ForumTopicResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumTopic extends CreateRecord
{
    protected static string $resource = ForumTopicResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
