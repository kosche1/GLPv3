<?php

namespace App\Filament\Resources\EquationDropResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'hint';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
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
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Equation Elements')
                            ->description('Define the equation display elements. Use "?" to mark where the answer should go.')
                            ->schema([
                                Forms\Components\Repeater::make('display_elements')
                                    ->label(false)
                                    ->schema([
                                        Forms\Components\TextInput::make('element')
                                            ->required()
                                            ->label(false)
                                            ->placeholder('Element (e.g., F, =, ?, ×, a)')
                                    ])
                                    ->columns(3)
                                    ->grid(3)
                                    ->required()
                                    ->minItems(2)
                                    ->defaultItems(3)
                                    ->collapsible(false)
                                    ->itemLabel(fn (array $state): ?string => $state['element'] ?? null),
                            ]),

                        Forms\Components\Section::make('Answer Options')
                            ->description('Define the possible answers for this equation')
                            ->schema([
                                Forms\Components\Repeater::make('options')
                                    ->label(false)
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('value')
                                                    ->required()
                                                    ->label('Value'),
                                                Forms\Components\Select::make('type')
                                                    ->required()
                                                    ->label('Type')
                                                    ->options([
                                                        'Variable' => 'Variable',
                                                        'Constant' => 'Constant',
                                                        'Compound' => 'Compound',
                                                        'Expression' => 'Expression',
                                                        'Operator' => 'Operator',
                                                        'Number' => 'Number',
                                                    ]),
                                            ]),
                                    ])
                                    ->required()
                                    ->minItems(2)
                                    ->maxItems(4)
                                    ->defaultItems(4)
                                    ->collapsible(false)
                                    ->itemLabel(fn (array $state): ?string => $state['value'] ?? null),
                            ]),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
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
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('answer')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('hint')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('display_elements')
                    ->label('Equation')
                    ->formatStateUsing(function ($state) {
                        $elements = collect($state)->pluck('element')->toArray();
                        return implode(' ', $elements);
                    })
                    ->tooltip(function ($state) {
                        $elements = collect($state)->pluck('element')->toArray();
                        return implode(' ', $elements);
                    })
                    ->limit(30),
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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Questions')
                    ->trueLabel('Active Questions')
                    ->falseLabel('Inactive Questions'),
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
