<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypingTestResultResource\Pages;
use App\Models\TypingTestResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                        Forms\Components\TextInput::make('user.name')
                            ->label('Student')
                            ->disabled(),
                        Forms\Components\TextInput::make('challenge.title')
                            ->label('Challenge')
                            ->disabled()
                            ->default('Free Typing'),
                        Forms\Components\TextInput::make('wpm')
                            ->label('Words Per Minute')
                            ->disabled(),
                        Forms\Components\TextInput::make('cpm')
                            ->label('Characters Per Minute')
                            ->disabled(),
                        Forms\Components\TextInput::make('accuracy')
                            ->label('Accuracy (%)')
                            ->disabled(),
                        Forms\Components\TextInput::make('test_mode')
                            ->label('Test Mode')
                            ->disabled(),
                        Forms\Components\TextInput::make('test_duration')
                            ->label('Test Duration (seconds)')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Test Date')
                            ->disabled(),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['user', 'challenge']));
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
            'view' => Pages\ViewTypingTestResult::route('/{record}'),
        ];
    }
}
