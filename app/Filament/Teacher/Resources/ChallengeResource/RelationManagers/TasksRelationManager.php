<?php

namespace App\Filament\Teacher\Resources\ChallengeResource\RelationManagers;

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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),
                    TextInput::make('points_reward')
                        ->numeric()
                        ->required()
                        ->columnSpan(1),
                ]),
                Textarea::make('description')
                    ->rows(2)
                    ->maxLength(500)
                    ->columnSpanFull(),
                RichEditor::make('instructions')
                    ->required()
                    ->columnSpanFull(),
                Grid::make(3)->schema([
                    Select::make('submission_type')
                        ->options([
                            'text' => 'Text / Code / Essay',
                            'file' => 'File Upload',
                            'url' => 'URL',
                            'multiple_choice' => 'Multiple Choice',
                            'numerical' => 'Numerical',
                        ])
                        ->required()
                        ->live()
                        ->columnSpan(1),
                    Select::make('evaluation_type')
                        ->options(function (Forms\Get $get) {
                            $submissionType = $get('submission_type');
                            $options = [
                                'manual' => 'Manual Review',
                            ];
                            if (in_array($submissionType, ['text', 'numerical'])) {
                                $options['exact_match'] = 'Exact Match';
                                $options['regex'] = 'Regex Match';
                            }
                            if ($submissionType === 'multiple_choice') {
                                $options['multiple_choice'] = 'Multiple Choice Check';
                            }
                            if ($submissionType === 'text') {
                            }
                            return $options;
                        })
                        ->required()
                        ->live()
                        ->columnSpan(1),
                    TextInput::make('order')
                        ->numeric()
                        ->default(0)
                        ->columnSpan(1),
                ]),

                Forms\Components\Section::make('Evaluation Details')
                    ->schema(function (Forms\Get $get): array {
                        $evalType = $get('evaluation_type');
                        return match ($evalType) {
                            'exact_match' => [
                                Textarea::make('evaluation_details.expected')
                                    ->label('Expected Answer')
                                    ->helperText('The exact string or numerical value expected.')
                                    ->required(),
                            ],
                            'regex' => [
                                TextInput::make('evaluation_details.pattern')
                                    ->label('Regex Pattern')
                                    ->helperText('The regular expression pattern to match against the submission.')
                                    ->required(),
                            ],
                            'multiple_choice' => [
                                Repeater::make('evaluation_details.options')
                                    ->label('Answer Options')
                                    ->schema([
                                        TextInput::make('option_text')->required()->label('Option Text'),
                                    ])
                                    ->minItems(2)
                                    ->addActionLabel('Add Option')
                                    ->required(),
                                Forms\Components\CheckboxList::make('evaluation_details.correct_indices')
                                    ->label('Correct Option(s)')
                                    ->options(function (Forms\Get $get) {
                                        $options = $get('evaluation_details.options') ?? [];
                                        $choices = [];
                                        foreach ($options as $index => $option) {
                                            $choices[$index] = $option['option_text'] ?: 'Option ' . ($index + 1);
                                        }
                                        return $choices;
                                    })
                                    ->helperText('Select the index (starting from 0) of the correct answer(s).')
                                    ->required()
                                    ->columns(1),
                            ],
                            'manual' => [
                                RichEditor::make('evaluation_details.rubric')
                                    ->label('Grading Rubric / Guidelines')
                                    ->helperText('(Optional) Provide guidelines or a rubric for manual grading.'),
                            ],
                            default => [],
                        };
                    })
                    ->visible(fn (Forms\Get $get) => !empty($get('evaluation_type')) && $get('evaluation_type') !== 'manual')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(fn ($state) => $state ?: 'No description'),
                Tables\Columns\TextColumn::make('points_reward')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission_type')
                    ->label('Submission')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'primary',
                        'numerical' => 'info',
                        'multiple_choice' => 'success',
                        'file' => 'warning',
                        'url' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('evaluation_type')
                    ->label('Evaluation')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual' => 'gray',
                        'exact_match' => 'success',
                        'regex' => 'info',
                        'multiple_choice' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                // Add filters if needed, e.g., by submission_type, evaluation_type
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {
                        // Update challenge points based on the new task
                        $record->challenge->updatePointsReward();

                        // NOTE: Syncing experience points here is PREMATURE.
                        // Points should be awarded AFTER successful evaluation of a StudentAnswer.
                    }),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'description'])
                    ->after(function ($record) {
                        // Update the challenge points after attaching tasks
                        $this->ownerRecord->updatePointsReward();

                        // NOTE: Syncing experience points here is PREMATURE.
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function ($record, $data) {
                        // Update challenge points after editing a task
                        $record->challenge->updatePointsReward();

                        // NOTE: Syncing experience points here needs refinement.
                        // It should likely happen when a StudentAnswer is updated to 'correct'
                        // and the points for the task changed.
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record) {
                        // Update the challenge points after deleting a task
                        $record->challenge->updatePointsReward();
                        // Potentially need to revoke points if answers existed?
                    }),
                Tables\Actions\DetachAction::make()
                    ->after(function ($record) {
                        $this->ownerRecord->updatePointsReward();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            $this->ownerRecord->updatePointsReward();
                        }),
                    Tables\Actions\DetachBulkAction::make()
                        ->after(function () {
                            $this->ownerRecord->updatePointsReward();
                        }),
                ]),
            ]);
    }

    /**
     * Sync experience points for users who have completed the task
     * NOTE: This entire method is likely OBSOLETE or needs significant refactoring.
     * Awarding points should be tied to StudentAnswer evaluation, not just task CRUD.
     *
     * @param Task $task
     * @return void
     */
    // protected function syncExperiencePointsForTask(Task $task): void
    // {
    //     // Get all users who have successfully completed this task
    //     $completedAnswers = $task->studentAnswers()
    //         ->where('is_correct', true) // Or check status == 'correct'
    //         ->with('user') // Eager load user
    //         ->get();

    //     // Award experience points to each user
    //     foreach ($completedAnswers as $answer) {
    //         if ($answer->user) {
    //             Experience::awardTaskPoints($answer->user, $task); // This might award points multiple times if task is edited
    //         }
    //     }
    // }
}