<?php

namespace App\Filament\Teacher\Resources\ForumCommentResource\Pages;

use App\Filament\Teacher\Resources\ForumCommentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumComment extends CreateRecord
{
    protected static string $resource = ForumCommentResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
