<?php

namespace App\Filament\Resources\StudyGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DiscussionsRelationManager extends RelationManager
{
    protected static string $relationship = 'discussions';
    protected static ?string $title = 'Discussions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true),
                
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->rows(5)
                    ->maxLength(5000),
                
                Forms\Components\Select::make('user_id')
                    ->label('Author')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                
                Forms\Components\Toggle::make('is_pinned')
                    ->label('Pin Discussion')
                    ->helperText('Pinned discussions appear at the top'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('📌')
                    ->boolean()
                    ->trueIcon('heroicon-s-bookmark')
                    ->falseIcon('')
                    ->trueColor('warning'),
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('content')
                    ->label('Preview')
                    ->limit(100)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('comments_count')
                    ->label('Comments')
                    ->counts('comments')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Pinned')
                    ->placeholder('All discussions')
                    ->trueLabel('Pinned only')
                    ->falseLabel('Not pinned'),
                
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Author')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data, RelationManager $livewire): array {
                        $data['study_group_id'] = $livewire->getOwnerRecord()->id;
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record) => route('study-groups.discussions.show', [
                        'studyGroup' => $this->getOwnerRecord(),
                        'discussion' => $record
                    ]))
                    ->openUrlInNewTab(),
                
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\Action::make('toggle_pin')
                    ->label(fn ($record) => $record->is_pinned ? 'Unpin' : 'Pin')
                    ->icon(fn ($record) => $record->is_pinned ? 'heroicon-o-bookmark-slash' : 'heroicon-o-bookmark')
                    ->color(fn ($record) => $record->is_pinned ? 'warning' : 'gray')
                    ->action(function ($record) {
                        $record->is_pinned = !$record->is_pinned;
                        $record->save();
                    }),
                
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('pin')
                        ->label('Pin Selected')
                        ->icon('heroicon-o-bookmark')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_pinned' => true]);
                            });
                        }),
                    
                    Tables\Actions\BulkAction::make('unpin')
                        ->label('Unpin Selected')
                        ->icon('heroicon-o-bookmark-slash')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_pinned' => false]);
                            });
                        }),
                ]),
            ])
            ->defaultSort('is_pinned', 'desc')
            ->defaultSort('created_at', 'desc');
    }
}
