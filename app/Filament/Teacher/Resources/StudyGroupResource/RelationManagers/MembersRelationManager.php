<?php

namespace App\Filament\Teacher\Resources\StudyGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use App\Models\User;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';
    protected static ?string $title = 'Members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('role')
                    ->options([
                        'member' => 'Member',
                        'moderator' => 'Moderator',
                        'leader' => 'Leader',
                    ])
                    ->required()
                    ->default('member'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=random&color=fff'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\SelectColumn::make('pivot.role')
                    ->label('Role')
                    ->options([
                        'member' => 'Member',
                        'moderator' => 'Moderator',
                        'leader' => 'Leader',
                    ])
                    ->selectablePlaceholder(false)
                    ->disabled(fn ($record, RelationManager $livewire) =>
                        !$this->canManageMembers($livewire->getOwnerRecord())
                    )
                    ->beforeStateUpdated(function ($record, $state, RelationManager $livewire) {
                        if (!$this->canManageMembers($livewire->getOwnerRecord())) {
                            return false;
                        }

                        // Prevent removing the last leader
                        if ($record->pivot->role === 'leader' && $state !== 'leader') {
                            $leaderCount = $livewire->getOwnerRecord()->members()
                                ->wherePivot('role', 'leader')
                                ->count();

                            if ($leaderCount <= 1) {
                                Notification::make()
                                    ->title('Cannot change role')
                                    ->body('Cannot remove the last leader from the group.')
                                    ->danger()
                                    ->send();

                                return false;
                            }
                        }

                        return true;
                    }),

                Tables\Columns\TextColumn::make('pivot.joined_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable(false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'member' => 'Member',
                        'moderator' => 'Moderator',
                        'leader' => 'Leader',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value']) {
                            return $query->wherePivot('role', $data['value']);
                        }
                        return $query;
                    }),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Add Member')
                    ->visible(fn (RelationManager $livewire) => $this->canManageMembers($livewire->getOwnerRecord()))
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->searchable()
                            ->preload()
                            ->getSearchResultsUsing(function (string $search) {
                                return User::where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->limit(50)
                                    ->pluck('name', 'id');
                            }),

                        Forms\Components\Select::make('role')
                            ->options([
                                'member' => 'Member',
                                'moderator' => 'Moderator',
                                'leader' => 'Leader',
                            ])
                            ->required()
                            ->default('member'),
                    ])
                    ->attachAnother(false)
                    ->preloadRecordSelect()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['joined_at'] = now();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->visible(fn ($record, RelationManager $livewire) =>
                        $this->canManageMembers($livewire->getOwnerRecord())
                    )
                    ->before(function ($record, RelationManager $livewire) {
                        // Prevent removing the last leader
                        if ($record->pivot->role === 'leader') {
                            $leaderCount = $livewire->getOwnerRecord()->members()
                                ->wherePivot('role', 'leader')
                                ->count();

                            if ($leaderCount <= 1) {
                                Notification::make()
                                    ->title('Cannot remove member')
                                    ->body('Cannot remove the last leader from the group.')
                                    ->danger()
                                    ->send();

                                return false;
                            }
                        }

                        return true;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->visible(fn (RelationManager $livewire) => $this->canManageMembers($livewire->getOwnerRecord())),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }

    private function canManageMembers($studyGroup): bool
    {
        return $studyGroup->created_by === auth()->id() || $studyGroup->isModerator(auth()->user());
    }
}
