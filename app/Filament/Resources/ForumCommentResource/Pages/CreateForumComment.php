<?php

namespace App\Filament\Resources\ForumCommentResource\Pages;

use App\Filament\Resources\ForumCommentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumComment extends CreateRecord
{
    protected static string $resource = ForumCommentResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
