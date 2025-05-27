<?php

namespace App\Filament\Resources\StudyGroupResource\Pages;

use App\Filament\Resources\StudyGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStudyGroups extends ListRecords
{
    protected static string $resource = StudyGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Groups'),
            'public' => Tab::make('Public Groups')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_private', false)),
            'private' => Tab::make('Private Groups')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_private', true)),
            'active' => Tab::make('Active Groups')
                ->modifyQueryUsing(fn (Builder $query) => $query->has('members')),
            'full' => Tab::make('Full Groups')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereRaw('(SELECT COUNT(*) FROM study_group_user WHERE study_group_id = study_groups.id) >= max_members')),
        ];
    }
}
