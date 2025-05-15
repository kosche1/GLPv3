<?php

namespace App\Filament\Resources\EquationDropResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'hint';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('answer')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('hint')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('display_elements')
                    ->label('Equation Display Elements')
                    ->schema([
                        Forms\Components\TextInput::make('element')
                            ->required()
                            ->helperText('Use "?" to mark where the answer should go'),
                    ])
                    ->columns(1)
                    ->required()
                    ->minItems(2)
                    ->defaultItems(3),
                Forms\Components\Repeater::make('options')
                    ->label('Answer Options')
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->label('Option Value'),
                        Forms\Components\TextInput::make('type')
                            ->required()
                            ->label('Option Type')
                            ->helperText('e.g., Variable, Constant, Compound, Expression, Operator, Number'),
                    ])
                    ->columns(2)
                    ->required()
                    ->minItems(2)
                    ->maxItems(4)
                    ->defaultItems(4),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('answer'),
                Tables\Columns\TextColumn::make('hint'),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
            ->defaultSort('order');
    }
}
