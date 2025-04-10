<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\ForumCommentResource\Pages;
use App\Models\ForumComment;
use App\Models\ForumTopic;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ForumCommentResource extends Resource
{
    protected static ?string $model = ForumComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationLabel = 'Forum Comments';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?int $navigationSort = 2;

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
                Tables\Columns\TextColumn::make('topic.title')
                    ->label('Topic')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable()
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('forum_topic_id')
                    ->label('Topic')
                    ->options(ForumTopic::pluck('title', 'id'))
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Show Only')
                    ->placeholder('All Comments')
                    ->trueLabel('Replies')
                    ->falseLabel('Top-level Comments')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('parent_id'),
                        false: fn (Builder $query) => $query->whereNull('parent_id'),
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
