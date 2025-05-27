<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyGroupResource\Pages;
use App\Filament\Resources\StudyGroupResource\RelationManagers;
use App\Models\StudyGroup;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StudyGroupResource extends Resource
{
    protected static ?string $model = StudyGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Study Groups';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(1000),

                        Forms\Components\Select::make('created_by')
                            ->label('Creator')
                            ->relationship('creator', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_private')
                            ->label('Private Group')
                            ->helperText('Private groups require a join code to access')
                            ->live(),

                        Forms\Components\TextInput::make('join_code')
                            ->label('Join Code')
                            ->maxLength(8)
                            ->visible(fn (Forms\Get $get) => $get('is_private'))
                            ->helperText('Leave empty to auto-generate'),

                        Forms\Components\TextInput::make('max_members')
                            ->label('Maximum Members')
                            ->numeric()
                            ->required()
                            ->default(10)
                            ->minValue(2)
                            ->maxValue(50),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Focus Areas')
                    ->schema([
                        Forms\Components\CheckboxList::make('focus_areas')
                            ->label('Categories')
                            ->options(Category::pluck('name', 'id'))
                            ->columns(3)
                            ->helperText('Select the main focus areas for this study group'),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Group Image')
                            ->image()
                            ->directory('study-groups')
                            ->maxSize(2048)
                            ->helperText('Upload an image for the study group (max 2MB)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://via.placeholder.com/40/771796'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Creator')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_private')
                    ->label('Private')
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-globe-alt')
                    ->trueColor('warning')
                    ->falseColor('success'),

                Tables\Columns\TextColumn::make('members_count')
                    ->label('Members')
                    ->counts('members')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('max_members')
                    ->label('Max')
                    ->sortable(),

                Tables\Columns\TextColumn::make('discussions_count')
                    ->label('Discussions')
                    ->counts('discussions')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('challenges_count')
                    ->label('Challenges')
                    ->counts('groupChallenges')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('join_code')
                    ->label('Join Code')
                    ->copyable()
                    ->copyMessage('Join code copied!')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_private')
                    ->label('Privacy')
                    ->placeholder('All groups')
                    ->trueLabel('Private groups')
                    ->falseLabel('Public groups'),

                SelectFilter::make('created_by')
                    ->label('Creator')
                    ->relationship('creator', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('has_members')
                    ->label('Has Members')
                    ->query(fn (Builder $query) => $query->has('members')),

                Tables\Filters\Filter::make('full_groups')
                    ->label('Full Groups')
                    ->query(fn (Builder $query) => $query->whereRaw('(SELECT COUNT(*) FROM study_group_user WHERE study_group_id = study_groups.id) >= max_members')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('regenerate_code')
                    ->label('New Code')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn (StudyGroup $record) => $record->is_private)
                    ->action(function (StudyGroup $record) {
                        $record->join_code = StudyGroup::generateJoinCode();
                        $record->save();

                        Notification::make()
                            ->title('Join code regenerated')
                            ->body("New join code: {$record->join_code}")
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Regenerate Join Code')
                    ->modalDescription('This will generate a new join code. The old code will no longer work.')
                    ->modalSubmitActionLabel('Regenerate'),
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
            RelationManagers\MembersRelationManager::class,
            RelationManagers\DiscussionsRelationManager::class,
            RelationManagers\ChallengesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudyGroups::route('/'),
            'create' => Pages\CreateStudyGroup::route('/create'),
            'view' => Pages\ViewStudyGroup::route('/{record}'),
            'edit' => Pages\EditStudyGroup::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['creator']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'creator.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Creator' => $record->creator->name,
            'Members' => $record->members->count() . '/' . $record->max_members,
            'Type' => $record->is_private ? 'Private' : 'Public',
        ];
    }
}
