<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumTopicResource\Pages;
use App\Filament\Resources\ForumTopicResource\RelationManagers;
use App\Models\ForumTopic;
use App\Models\ForumCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ForumTopicResource extends Resource
{
    protected static ?string $model = ForumTopic::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Forum Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('forum_category_id')
                    ->label('Category')
                    ->options(ForumCategory::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('user_id')
                    ->label('Author')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, Forms\Set $set) =>
                        $set('slug', Str::slug($state) . '-' . Str::random(5))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ForumTopic::class, 'slug', ignoreRecord: true),

                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('views_count')
                    ->numeric()
                    ->default(0),

                Forms\Components\TextInput::make('likes_count')
                    ->numeric()
                    ->default(0),

                Forms\Components\TextInput::make('comments_count')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_pinned')
                    ->default(false),

                Forms\Components\Toggle::make('is_locked')
                    ->default(false),

                Forms\Components\DateTimePicker::make('last_activity_at')
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('likes_count')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('comments_count')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_pinned')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_locked')
                    ->boolean(),

                Tables\Columns\TextColumn::make('last_activity_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('forum_category_id')
                    ->label('Category')
                    ->options(ForumCategory::pluck('name', 'id')),

                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Pinned Status'),

                Tables\Filters\TernaryFilter::make('is_locked')
                    ->label('Locked Status'),
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
            ->defaultSort('last_activity_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ForumCommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForumTopics::route('/'),
            'create' => Pages\CreateForumTopic::route('/create'),
            'edit' => Pages\EditForumTopic::route('/{record}/edit'),
        ];
    }
}
