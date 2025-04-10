<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\ForumTopicResource\Pages;
use App\Filament\Teacher\Resources\ForumTopicResource\RelationManagers;
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
    protected static ?string $navigationLabel = 'Forum Topics';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('forum_category_id')
                    ->label('Category')
                    ->options(ForumCategory::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->helperText('Categories are managed by administrators'),

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

                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_pinned')
                    ->label('Pin Topic')
                    ->default(false),

                Forms\Components\Toggle::make('is_locked')
                    ->label('Lock Topic')
                    ->default(false),
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
                    ->boolean()
                    ->label('Pinned')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_locked')
                    ->boolean()
                    ->label('Locked')
                    ->sortable(),

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
