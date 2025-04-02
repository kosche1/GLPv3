<?php

namespace App\Filament\Resources\ChallengeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Challenge;
use App\Models\Experience;
use App\Models\Task;
use App\Models\User;

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
                Forms\Components\Textarea::make('expected_output')
                    ->rows(3)
                    ->maxLength(1000),
                Forms\Components\KeyValue::make('expected_solution')
                    ->keyLabel('Key')
                    ->valueLabel('Solution')
                    ->addable()
                    ->deletable(),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
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
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expected_output')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('expected_solution')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {
                        // Update the challenge points after creating a task
                        $record->challenge->updatePointsReward();
                        
                        // If there are users who have already completed this task
                        // award them experience points retroactively
                        $this->syncExperiencePointsForTask($record);
                    }),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'description'])
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        Forms\Components\Select::make('records')
                            ->multiple()
                            ->label('Tasks')
                            ->options(fn ($livewire) => $livewire->ownerRecord->tasks()->pluck('name', 'id'))
                            ->required(),
                    ])
                    ->after(function ($record) {
                        // Update the challenge points after attaching tasks
                        $this->ownerRecord->updatePointsReward();
                        
                        // If the attached task was already completed by users
                        // award them experience points
                        $this->syncExperiencePointsForTask($record);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function ($record, $data) {
                        // Update the challenge points after editing a task
                        $record->challenge->updatePointsReward();
                        
                        // If points reward was changed, update users' experience
                        if (isset($data['points_reward']) && 
                            $data['points_reward'] != $record->getOriginal('points_reward')) {
                            $this->syncExperiencePointsForTask($record);
                        }
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record) {
                        // Update the challenge points after deleting a task
                        $record->challenge->updatePointsReward();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            // Update the challenge points after bulk deleting tasks
                            $this->ownerRecord->updatePointsReward();
                        }),
                    Tables\Actions\DetachBulkAction::make()
                        ->after(function () {
                            // Update the challenge points after bulk detaching tasks
                            $this->ownerRecord->updatePointsReward();
                        }),
                ]),

            ]);
    }
    
    /**
     * Sync experience points for users who have completed the task
     * 
     * @param Task $task
     * @return void
     */
    protected function syncExperiencePointsForTask(Task $task): void
    {
        // Get all users who have completed this task
        $completedUsers = $task->users()
            ->wherePivot('completed', true)
            ->get();
            
        // Award experience points to each user
        foreach ($completedUsers as $user) {
            Experience::awardTaskPoints($user, $task);
        }
    }
}
