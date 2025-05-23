<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquationDropResultResource\Pages;
use App\Models\EquationDropResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EquationDropResultResource extends Resource
{
    protected static ?string $model = EquationDropResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'Equation Drop Results';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Result Information')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->label('Student')
                            ->disabled(),
                        Forms\Components\TextInput::make('equationDrop.title')
                            ->label('Game')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Date')
                            ->disabled(),
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'easy' => 'Easy',
                                'medium' => 'Medium',
                                'hard' => 'Hard',
                            ])
                            ->disabled(),
                        Forms\Components\TextInput::make('score')
                            ->label('Score')
                            ->disabled(),
                        Forms\Components\TextInput::make('questions_attempted')
                            ->label('Questions Attempted')
                            ->disabled(),
                        Forms\Components\TextInput::make('questions_correct')
                            ->label('Questions Correct')
                            ->disabled(),
                        Forms\Components\TextInput::make('accuracy_percentage')
                            ->label('Accuracy (%)')
                            ->suffix('%')
                            ->disabled(),
                        Forms\Components\TextInput::make('time_spent_seconds')
                            ->label('Time Spent (seconds)')
                            ->disabled(),
                        Forms\Components\Toggle::make('completed')
                            ->label('Game Completed')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Student Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('questions_correct')
                    ->label('Correct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('questions_attempted')
                    ->label('Attempted')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accuracy_percentage')
                    ->label('Accuracy')
                    ->numeric(2)
                    ->suffix('%')
                    ->sortable()
                    ->color(fn (string $state): string => 
                        floatval($state) >= 80 ? 'success' : 
                        (floatval($state) >= 50 ? 'warning' : 'danger')
                    ),
                Tables\Columns\IconColumn::make('completed')
                    ->label('Completed')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),
                Tables\Filters\Filter::make('high_scorers')
                    ->label('High Scorers')
                    ->query(fn (Builder $query): Builder => $query->where('score', '>=', 500)),
                Tables\Filters\Filter::make('high_accuracy')
                    ->label('High Accuracy (80%+)')
                    ->query(fn (Builder $query): Builder => $query->where('accuracy_percentage', '>=', 80)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEquationDropResults::route('/'),
            'view' => Pages\ViewEquationDropResult::route('/{record}'),
        ];
    }
}
