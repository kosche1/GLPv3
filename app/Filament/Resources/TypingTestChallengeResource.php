<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypingTestChallengeResource\Pages;
use App\Models\TypingTestChallenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TypingTestChallengeResource extends Resource
{
    protected static ?string $model = TypingTestChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'Typing Speed Challenges';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Challenge Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Beginner Typing Challenge'),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->placeholder('Describe the challenge objectives and requirements')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',
                            ])
                            ->required()
                            ->default('beginner'),
                        Forms\Components\Select::make('test_mode')
                            ->options([
                                'words' => 'Word Count Based',
                                'time' => 'Time Based',
                            ])
                            ->required()
                            ->default('words')
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                                $state === 'words' ? $set('time_limit', 60) : $set('word_count', 25)
                            ),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Test Configuration')
                    ->schema([
                        Forms\Components\TextInput::make('word_count')
                            ->numeric()
                            ->default(25)
                            ->minValue(10)
                            ->maxValue(200)
                            ->visible(fn (Forms\Get $get): bool => $get('test_mode') === 'words')
                            ->helperText('Number of words students need to type'),
                        Forms\Components\TextInput::make('time_limit')
                            ->numeric()
                            ->default(60)
                            ->minValue(30)
                            ->maxValue(300)
                            ->suffix('seconds')
                            ->visible(fn (Forms\Get $get): bool => $get('test_mode') === 'time')
                            ->helperText('Time limit for the typing test'),
                        Forms\Components\TextInput::make('target_wpm')
                            ->label('Target WPM')
                            ->numeric()
                            ->default(30)
                            ->minValue(10)
                            ->maxValue(150)
                            ->helperText('Target words per minute for this challenge'),
                        Forms\Components\TextInput::make('target_accuracy')
                            ->label('Target Accuracy (%)')
                            ->numeric()
                            ->default(85)
                            ->minValue(50)
                            ->maxValue(100)
                            ->suffix('%')
                            ->helperText('Target accuracy percentage'),
                        Forms\Components\TextInput::make('points_reward')
                            ->label('Points Reward')
                            ->numeric()
                            ->default(50)
                            ->minValue(10)
                            ->maxValue(500)
                            ->helperText('Points awarded for completing this challenge'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Custom Word List (Optional)')
                    ->schema([
                        Forms\Components\Textarea::make('word_list_input')
                            ->label('Custom Words')
                            ->placeholder('Enter words separated by commas or new lines. Leave empty to use default word bank.')
                            ->helperText('Example: the, quick, brown, fox, jumps, over, lazy, dog')
                            ->columnSpanFull()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Components\Textarea $component, $record) {
                                if ($record && $record->word_list) {
                                    $component->state(implode(', ', $record->word_list));
                                }
                            }),
                        Forms\Components\Hidden::make('word_list')
                            ->dehydrateStateUsing(function (Forms\Get $get) {
                                $input = $get('word_list_input');
                                if (empty($input)) {
                                    return null;
                                }

                                // Split by comma or newline and clean up
                                $words = preg_split('/[,\n\r]+/', $input);
                                $words = array_map('trim', $words);
                                $words = array_filter($words, fn($word) => !empty($word));

                                return array_values($words);
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'success',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('test_mode')
                    ->label('Mode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'words' => 'success',
                        'time' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('word_count')
                    ->label('Words')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('time_limit')
                    ->label('Time (s)')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_wpm')
                    ->label('Target WPM')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_accuracy')
                    ->label('Target Acc.')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('points_reward')
                    ->label('Points')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ]),
                Tables\Filters\SelectFilter::make('test_mode')
                    ->options([
                        'words' => 'Word Count Based',
                        'time' => 'Time Based',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Challenges')
                    ->trueLabel('Active Challenges')
                    ->falseLabel('Inactive Challenges'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTypingTestChallenges::route('/'),
            'create' => Pages\CreateTypingTestChallenge::route('/create'),
            'edit' => Pages\EditTypingTestChallenge::route('/{record}/edit'),
            'view' => Pages\ViewTypingTestChallenge::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }
}
