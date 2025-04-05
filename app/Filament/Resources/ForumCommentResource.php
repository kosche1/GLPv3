<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumCommentResource\Pages;
use App\Models\ForumComment;
use App\Models\ForumTopic;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ForumCommentResource extends Resource
{
    protected static ?string $model = ForumComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    
    protected static ?string $navigationGroup = 'Forum Management';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('forum_topic_id')
                    ->label('Topic')
                    ->options(ForumTopic::pluck('title', 'id'))
                    ->required()
                    ->searchable(),
                
                Forms\Components\Select::make('user_id')
                    ->label('Author')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Comment')
                    ->options(ForumComment::pluck('id', 'id'))
                    ->searchable()
                    ->nullable(),
                
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('likes_count')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('topic.title')
                    ->label('Topic')
                    ->limit(30)
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('content')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('parent_id')
                    ->label('Is Reply')
                    ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('likes_count')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('forum_topic_id')
                    ->label('Topic')
                    ->options(ForumTopic::pluck('title', 'id')),
                
                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Comment Type')
                    ->placeholder('All Comments')
                    ->trueLabel('Replies Only')
                    ->falseLabel('Top-level Comments Only')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('parent_id'),
                        false: fn ($query) => $query->whereNull('parent_id'),
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForumComments::route('/'),
            'create' => Pages\CreateForumComment::route('/create'),
            'edit' => Pages\EditForumComment::route('/{record}/edit'),
        ];
    }
}
