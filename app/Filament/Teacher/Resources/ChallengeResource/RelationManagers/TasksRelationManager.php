<?php

namespace App\Filament\Teacher\Resources\ChallengeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Task Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('instructions')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('points_reward')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('submission_type')
                            ->options([
                                'code' => 'Code',
                                'text' => 'Text',
                                'file' => 'File',
                                'automatic' => 'Automatic',
                            ])
                            ->required(),
                        Forms\Components\Select::make('evaluation_type')
                            ->options([
                                'automated' => 'Automated',
                                'manual' => 'Manual Review',
                                'exact_match' => 'Exact Match',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('due_date'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->minValue(1),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('points_reward')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'code' => 'info',
                        'text' => 'success',
                        'file' => 'warning',
                        'automatic' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('evaluation_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'automated' => 'success',
                        'manual' => 'warning',
                        'exact_match' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
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
            ]);
    }
}
