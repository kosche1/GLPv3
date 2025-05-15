<?php

namespace App\Filament\Resources\HistoricalTimelineMazeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventsRelationManager extends RelationManager
{
    protected static string $relationship = 'events';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Historical Timeline Events';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('era')
                            ->options([
                                'ancient' => 'Ancient History (3000 BCE - 500 CE)',
                                'medieval' => 'Medieval Period (500 - 1500 CE)',
                                'renaissance' => 'Renaissance & Early Modern (1500 - 1800 CE)',
                                'modern' => 'Modern Era (1800 - 1945 CE)',
                                'contemporary' => 'Contemporary History (1945 - Present)',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order'),
                    ]),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('year')
                    ->required()
                    ->maxLength(255)
                    ->label('Year/Period')
                    ->placeholder('e.g., 1776 CE, 500-400 BCE, etc.'),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(1000)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('era')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ancient' => 'info',
                        'medieval' => 'success',
                        'renaissance' => 'warning',
                        'modern' => 'danger',
                        'contemporary' => 'gray',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('year')
                    ->label('Year/Period')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('era')
                    ->options([
                        'ancient' => 'Ancient History',
                        'medieval' => 'Medieval Period',
                        'renaissance' => 'Renaissance & Early Modern',
                        'modern' => 'Modern Era',
                        'contemporary' => 'Contemporary History',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Events')
                    ->trueLabel('Active Events')
                    ->falseLabel('Inactive Events'),
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
            ->defaultSort('order')
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('era')->orderBy('order'));
    }
}
