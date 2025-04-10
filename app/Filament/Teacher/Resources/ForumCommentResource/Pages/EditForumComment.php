<?php

namespace App\Filament\Teacher\Resources\ForumCommentResource\Pages;

use App\Filament\Teacher\Resources\ForumCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForumComment extends EditRecord
{
    protected static string $resource = ForumCommentResource::class;

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
