<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = "heroicon-o-clipboard";
    protected static ?string $navigationGroup = "Rewards";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                TextInput::make('points_reward')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->columnSpan(1),
            ]),
            Textarea::make('description')
                ->rows(2)
                ->maxLength(500)
                ->helperText('A brief summary for display in tables.')
                ->columnSpanFull(),
            RichEditor::make('instructions')
                ->required()
                ->helperText('Detailed instructions or question for the task.')
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
                                ->required(),
                        ],
                        'regex' => [
                            TextInput::make('evaluation_details.pattern')
                                ->label('Regex Pattern')
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
                                ->required()
                                ->columns(1),
                        ],
                        'manual' => [
                            RichEditor::make('evaluation_details.rubric')
                                ->label('Grading Rubric / Guidelines (Optional)'),
                        ],
                        default => [],
                    };
                })
                ->visible(fn (Forms\Get $get) => !empty($get('evaluation_type')) && $get('evaluation_type') !== 'manual')
                ->columnSpanFull(),
            Toggle::make('is_active')
                ->label('Active')
                ->default(true)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('challenge.name')
                    ->label('Challenge')
                    ->sortable()
                    ->searchable()
                    ->default('-')
                    ->url(fn (Task $record): string => $record->challenge ? ChallengeResource::getUrl('edit', ['record' => $record->challenge_id]) : '#')
                    ->openUrlInNewTab(fn (Task $record): bool => (bool)$record->challenge_id),
                Tables\Columns\TextColumn::make('points_reward')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('submission_type')
                    ->label('Submission'),
                Tables\Columns\BadgeColumn::make('evaluation_type')
                    ->label('Evaluation'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('submission_type')
                    ->options([
                        'text' => 'Text / Code / Essay',
                        'file' => 'File Upload',
                        'url' => 'URL',
                        'multiple_choice' => 'Multiple Choice',
                        'numerical' => 'Numerical',
                    ]),
                Tables\Filters\SelectFilter::make('evaluation_type')
                    ->options([
                        'manual' => 'Manual Review',
                        'exact_match' => 'Exact Match',
                        'regex' => 'Regex Match',
                        'multiple_choice' => 'Multiple Choice Check',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Tables\Filters\Filter::make('challenge_id')
                    ->label('Linked to Challenge')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('challenge_id'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('attachToChallenge')
                    ->label('Attach to Challenge')
                    ->icon('heroicon-s-link')
                    ->visible(fn (Task $record): bool => $record->challenge_id === null)
                    ->form([
                        Forms\Components\Select::make('challenge_id')
                            ->label('Select Challenge')
                            ->options(fn () => \App\Models\Challenge::where('is_active', true)
                                ->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                    ])
                    ->action(function (Task $record, array $data): void {
                        $record->update(['challenge_id' => $data['challenge_id']]);
                        if($record->challenge) {
                            $record->challenge->updatePointsReward();
                        }
                        Notification::make()
                            ->success()
                            ->title('Task attached to challenge successfully')
                            ->send();
                    })
                    ->color('gray'),
                Tables\Actions\Action::make('detachFromChallenge')
                    ->label('Detach from Challenge')
                    ->icon('heroicon-s-no-symbol')
                    ->visible(fn (Task $record): bool => $record->challenge_id !== null)
                    ->requiresConfirmation()
                    ->action(function (Task $record): void {
                        $challenge = $record->challenge;
                        $record->update(['challenge_id' => null]);
                        if($challenge) {
                            $challenge->updatePointsReward();
                        }
                        Notification::make()
                            ->success()
                            ->title('Task detached from challenge successfully')
                            ->send();
                    })
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Potentially add StudentAnswersRelationManager here if useful
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTasks::route("/"),
            "create" => Pages\CreateTask::route("/create"),
            "edit" => Pages\EditTask::route("/{record}/edit"),
        ];
    }
}
