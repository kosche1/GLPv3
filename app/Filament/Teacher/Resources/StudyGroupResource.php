<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\StudyGroupResource\Pages;
use App\Filament\Teacher\Resources\StudyGroupResource\RelationManagers;
use App\Models\StudyGroup;
use App\Models\Category;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class StudyGroupResource extends Resource
{
    protected static ?string $model = StudyGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Study Groups';
    protected static ?string $navigationGroup = 'Student Management';
    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        // Teachers can only see groups they created or are members of
        return parent::getEloquentQuery()
            ->where(function (Builder $query) {
                $query->where('created_by', auth()->id())
                    ->orWhereHas('members', function (Builder $query) {
                        $query->where('user_id', auth()->id());
                    });
            });
    }

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
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => $record->created_by === auth()->id() ? 'success' : 'gray'),

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

                Tables\Columns\TextColumn::make('my_role')
                    ->label('My Role')
                    ->state(function (StudyGroup $record) {
                        $member = $record->members()->where('user_id', auth()->id())->first();
                        return $member ? ucfirst($member->pivot->role) : 'Not a member';
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Leader' => 'success',
                        'Moderator' => 'warning',
                        'Member' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_private')
                    ->label('Privacy')
                    ->placeholder('All groups')
                    ->trueLabel('Private groups')
                    ->falseLabel('Public groups'),

                SelectFilter::make('my_role')
                    ->label('My Role')
                    ->options([
                        'leader' => 'Leader',
                        'moderator' => 'Moderator',
                        'member' => 'Member',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            return $query->whereHas('members', function (Builder $query) use ($data) {
                                $query->where('user_id', auth()->id())
                                    ->where('role', $data['value']);
                            });
                        }
                        return $query;
                    }),

                Tables\Filters\Filter::make('created_by_me')
                    ->label('Created by Me')
                    ->query(fn (Builder $query) => $query->where('created_by', auth()->id())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (StudyGroup $record) =>
                        $record->created_by === auth()->id() ||
                        $record->isModerator(auth()->user())
                    ),
                Tables\Actions\Action::make('view_frontend')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (StudyGroup $record) => route('study-groups.show', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->hasRole('admin')),
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
        return static::getEloquentQuery()->count();
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit($record): bool
    {
        return $record->created_by === auth()->id() || $record->isModerator(auth()->user());
    }

    public static function canDelete($record): bool
    {
        return $record->created_by === auth()->id() || auth()->user()->hasRole('admin');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
