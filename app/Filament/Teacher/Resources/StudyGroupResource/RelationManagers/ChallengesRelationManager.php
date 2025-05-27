<?php

namespace App\Filament\Teacher\Resources\StudyGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Category;

class ChallengesRelationManager extends RelationManager
{
    protected static string $relationship = 'groupChallenges';
    protected static ?string $title = 'Group Challenges';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(1000),
                        
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Select::make('difficulty_level')
                            ->options([
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',
                                'expert' => 'Expert',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Challenge Details')
                    ->schema([
                        Forms\Components\Textarea::make('challenge_content')
                            ->label('Challenge Content')
                            ->rows(5)
                            ->maxLength(10000),
                        
                        Forms\Components\Textarea::make('completion_criteria')
                            ->label('Completion Criteria')
                            ->rows(3)
                            ->maxLength(2000),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Start Date'),
                        
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('End Date'),
                        
                        Forms\Components\TextInput::make('points_reward')
                            ->label('Points Reward')
                            ->numeric()
                            ->minValue(0),
                        
                        Forms\Components\TextInput::make('time_limit')
                            ->label('Time Limit (minutes)')
                            ->numeric()
                            ->minValue(0),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('difficulty_level')
                    ->label('Difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'success',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        'expert' => 'gray',
                        default => 'gray',
                    }),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                Tables\Columns\TextColumn::make('participants_count')
                    ->label('Participants')
                    ->counts('participants')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('points_reward')
                    ->label('Points')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn ($state) => $state ? $state . ' pts' : '—'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All challenges')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                
                Tables\Filters\SelectFilter::make('difficulty_level')
                    ->label('Difficulty')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                        'expert' => 'Expert',
                    ]),
                
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn (RelationManager $livewire) => $this->canCreateChallenges($livewire->getOwnerRecord()))
                    ->mutateFormDataUsing(function (array $data, RelationManager $livewire): array {
                        $data['study_group_id'] = $livewire->getOwnerRecord()->id;
                        $data['created_by'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record, RelationManager $livewire) => route('study-groups.challenges.show', [
                        'studyGroup' => $livewire->getOwnerRecord(),
                        'groupChallenge' => $record
                    ]))
                    ->openUrlInNewTab(),
                
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record, RelationManager $livewire) => 
                        $record->created_by === auth()->id() || $this->canModerate($livewire->getOwnerRecord())
                    ),
                
                Tables\Actions\Action::make('toggle_active')
                    ->label(fn ($record) => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-pause' : 'heroicon-o-play')
                    ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                    ->visible(fn ($record, RelationManager $livewire) => 
                        $record->created_by === auth()->id() || $this->canModerate($livewire->getOwnerRecord())
                    )
                    ->action(function ($record) {
                        $record->is_active = !$record->is_active;
                        $record->save();
                    }),
                
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record, RelationManager $livewire) => 
                        $record->created_by === auth()->id() || $this->canModerate($livewire->getOwnerRecord())
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn (RelationManager $livewire) => $this->canModerate($livewire->getOwnerRecord())),
                    
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-play')
                        ->color('success')
                        ->visible(fn (RelationManager $livewire) => $this->canModerate($livewire->getOwnerRecord()))
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        }),
                    
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-pause')
                        ->color('danger')
                        ->visible(fn (RelationManager $livewire) => $this->canModerate($livewire->getOwnerRecord()))
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    private function canCreateChallenges($studyGroup): bool
    {
        return $studyGroup->created_by === auth()->id() || $studyGroup->isModerator(auth()->user());
    }

    private function canModerate($studyGroup): bool
    {
        return $studyGroup->created_by === auth()->id() || $studyGroup->isModerator(auth()->user());
    }
}
