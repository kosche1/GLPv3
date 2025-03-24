<?php

namespace App\Filament\Resources\ChallengeResource\RelationManagers;

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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->maxLength(1000),
                Forms\Components\TextInput::make('points_reward')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'coding' => 'Coding',
                        'quiz' => 'Quiz',
                        'project' => 'Project',
                        'research' => 'Research',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\KeyValue::make('completion_criteria')
                    ->keyLabel('Criteria')
                    ->valueLabel('Requirement')
                    ->addable()
                    ->deletable(),
                Forms\Components\KeyValue::make('additional_rewards')
                    ->keyLabel('Reward Type')
                    ->valueLabel('Value')
                    ->addable()
                    ->deletable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('points_reward')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'coding' => 'success',
                        'quiz' => 'info',
                        'project' => 'warning',
                        'research' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'description'])
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        Forms\Components\Select::make('records')
                            ->multiple()
                            ->label('Tasks')
                            ->options(fn ($livewire) => $livewire->ownerRecord->tasks()->pluck('name', 'id'))
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
