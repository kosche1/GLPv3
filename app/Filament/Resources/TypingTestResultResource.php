<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypingTestResultResource\Pages;
use App\Models\TypingTestResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TypingTestResultResource extends Resource
{
    protected static ?string $model = TypingTestResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'Typing Speed Results';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Test Results')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Student')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('challenge_id')
                            ->label('Challenge')
                            ->relationship('challenge', 'title')
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('wpm')
                            ->label('Words Per Minute')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        Forms\Components\TextInput::make('cpm')
                            ->label('Characters Per Minute')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        Forms\Components\TextInput::make('accuracy')
                            ->label('Accuracy (%)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(100),

                        Forms\Components\Select::make('test_mode')
                            ->label('Test Mode')
                            ->options([
                                'words' => 'Word Count',
                                'time' => 'Timed Test',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('word_count')
                            ->label('Words Typed')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        Forms\Components\TextInput::make('time_limit')
                            ->label('Time Limit (seconds)')
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\TextInput::make('test_duration')
                            ->label('Test Duration (seconds)')
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\TextInput::make('characters_typed')
                            ->label('Characters Typed')
                            ->numeric()
                            ->minValue(0),

                        Forms\Components\TextInput::make('errors')
                            ->label('Errors')
                            ->numeric()
                            ->minValue(0),

                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Test Date')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('challenge.title')
                    ->label('Challenge')
                    ->searchable()
                    ->sortable()
                    ->default('Free Typing')
                    ->description(fn (TypingTestResult $record): string =>
                        $record->challenge
                            ? "Difficulty: " . ucfirst($record->challenge->difficulty)
                            : "No specific challenge"
                    ),
                Tables\Columns\TextColumn::make('wpm')
                    ->label('WPM')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cpm')
                    ->label('CPM')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accuracy')
                    ->label('Accuracy')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('test_mode')
                    ->label('Mode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'words' => 'success',
                        'time' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('approved')
                    ->label('Approved')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Approved By')
                    ->placeholder('Not approved')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('test_mode')
                    ->options([
                        'words' => 'Words',
                        'time' => 'Timed',
                    ]),
                Tables\Filters\SelectFilter::make('challenge')
                    ->relationship('challenge', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('free_typing')
                    ->label('Free Typing Only')
                    ->query(fn (Builder $query): Builder => $query->whereNull('challenge_id')),
                Tables\Filters\Filter::make('high_performers')
                    ->label('High Performers')
                    ->query(fn (Builder $query): Builder => $query->where('wpm', '>=', 60)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (TypingTestResult $record): bool => !$record->approved && $record->challenge_id !== null)
                    ->requiresConfirmation()
                    ->modalHeading('Approve Typing Test Result')
                    ->modalDescription(fn (TypingTestResult $record): string =>
                        "Are you sure you want to approve this typing test result? This will award " .
                        ($record->challenge?->points_reward ?? 0) . " points to " . ($record->user?->name ?? 'the student') . "."
                    )
                    ->action(function (TypingTestResult $record): void {
                        $user = $record->user;
                        $challenge = $record->challenge;

                        if (!$user || !$challenge) {
                            Notification::make()
                                ->danger()
                                ->title('Error')
                                ->body('Unable to approve: User or challenge not found.')
                                ->send();
                            return;
                        }

                        // Update the record
                        $record->update([
                            'approved' => true,
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                            'points_awarded' => true,
                            'notification_shown' => false, // Will trigger notification to student
                        ]);

                        // Award points to the user
                        $pointsToAward = $challenge->points_reward ?? 0;
                        if ($pointsToAward > 0) {
                            $user->addPoints(
                                amount: $pointsToAward,
                                reason: "Typing test approved: {$challenge->title}"
                            );
                        }

                        // Show success notification
                        Notification::make()
                            ->success()
                            ->title('Result Approved')
                            ->body("Approved typing test result and awarded {$pointsToAward} points to {$user->name}")
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['user', 'challenge'])->whereNotNull('challenge_id'));
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
            'index' => Pages\ListTypingTestResults::route('/'),
            'create' => Pages\CreateTypingTestResult::route('/create'),
            'view' => Pages\ViewTypingTestResult::route('/{record}'),
            'edit' => Pages\EditTypingTestResult::route('/{record}/edit'),
        ];
    }
}
