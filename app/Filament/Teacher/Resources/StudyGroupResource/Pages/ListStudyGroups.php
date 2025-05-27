<?php

namespace App\Filament\Teacher\Resources\StudyGroupResource\Pages;

use App\Filament\Teacher\Resources\StudyGroupResource;
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
            'my_groups' => Tab::make('My Groups')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_by', auth()->id())),
            'leader' => Tab::make('Leading')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('members', function (Builder $query) {
                    $query->where('user_id', auth()->id())->where('role', 'leader');
                })),
            'moderating' => Tab::make('Moderating')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('members', function (Builder $query) {
                    $query->where('user_id', auth()->id())->where('role', 'moderator');
                })),
            'member' => Tab::make('Member')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('members', function (Builder $query) {
                    $query->where('user_id', auth()->id())->where('role', 'member');
                })),
        ];
    }
}
