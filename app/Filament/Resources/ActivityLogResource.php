<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\ActivityLogResource\Pages;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 99;

    public static function getNavigationLabel(): string
    {
        return 'Audit Trail';
    }

    public static function getPluralLabel(): string
    {
        return 'Audit Trail';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('log_name')
                            ->label('Subject Type')
                            ->required(),

                        Forms\Components\TextInput::make('description')
                            ->label('Description')
                            ->required(),

                        Forms\Components\TextInput::make('event')
                            ->label('Action')
                            ->required(),

                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Created At')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('causer_type')
                            ->label('User Type')
                            ->disabled(),

                        Forms\Components\TextInput::make('causer_id')
                            ->label('User ID')
                            ->disabled(),

                        Forms\Components\Placeholder::make('causer_info')
                            ->label('User Details')
                            ->content(function ($record) {
                                if (!$record->causer) {
                                    return 'System';
                                }

                                if ($record->causer instanceof \App\Models\User) {
                                    return "Name: {$record->causer->name}\nEmail: {$record->causer->email}";
                                }

                                return class_basename($record->causer_type) . ' #' . $record->causer_id;
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Resource Information')
                    ->schema([
                        Forms\Components\TextInput::make('subject_type')
                            ->label('Resource Type')
                            ->disabled(),

                        Forms\Components\TextInput::make('subject_id')
                            ->label('Resource ID')
                            ->disabled(),

                        Forms\Components\Placeholder::make('subject_info')
                            ->label('Resource Details')
                            ->content(function ($record) {
                                if (!$record->subject) {
                                    return 'No resource information available';
                                }

                                if ($record->subject instanceof \App\Models\Challenge) {
                                    return "Challenge: {$record->subject->name}\nDifficulty: {$record->subject->difficulty_level}";
                                }

                                if ($record->subject instanceof \App\Models\Task) {
                                    return "Task: {$record->subject->name}\nChallenge ID: {$record->subject->challenge_id}";
                                }

                                if ($record->subject instanceof \App\Models\StudentAnswer) {
                                    return "Student Answer for Task #{$record->subject->task_id}\nStatus: {$record->subject->status}";
                                }

                                return "Type: " . class_basename($record->subject_type) . "\nID: " . $record->subject_id;
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Properties')
                    ->schema([
                        Forms\Components\KeyValue::make('properties')
                            ->label('Properties'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Subject column - Shows the challenge or task name when available
                TextColumn::make('subject.name')
                    ->label('Subject')
                    ->description(fn ($record) => $record->subject_type ? class_basename($record->subject_type) : null)
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        // If log_name is a user name (likely from tapActivity method), don't show it here
                        if ($record->causer_type === 'App\\Models\\User' && $record->log_name === $record->causer->name) {
                            // Instead, show the subject type if available
                            if ($record->subject_type) {
                                return class_basename($record->subject_type);
                            }
                            return 'Activity';
                        }

                        // If subject is a Challenge or Task, show its name
                        if ($state) {
                            return $state;
                        }

                        // If subject is a StudentAnswer, try to get the challenge name (subject name)
                        if ($record->subject_type === 'App\\Models\\StudentAnswer') {
                            // First try to get task_id from properties
                            $properties = $record->properties;
                            if (isset($properties['task_id'])) {
                                // Load the task with its challenge
                                $task = \App\Models\Task::with('challenge')->find($properties['task_id']);
                                if ($task && $task->challenge) {
                                    // Return the challenge name (subject name)
                                    return $task->challenge->name;
                                }
                            }

                            // If not found in properties, try to load the StudentAnswer and get the task
                            if ($record->subject_id) {
                                $studentAnswer = \App\Models\StudentAnswer::with('task.challenge')->find($record->subject_id);
                                if ($studentAnswer && $studentAnswer->task && $studentAnswer->task->challenge) {
                                    return $studentAnswer->task->challenge->name;
                                }
                                if ($studentAnswer && $studentAnswer->task) {
                                    return $studentAnswer->task->name;
                                }
                                if ($studentAnswer && $studentAnswer->task_id) {
                                    return 'Task #' . $studentAnswer->task_id;
                                }
                            }

                            // If we have a task_id in properties but couldn't load the task
                            if (isset($properties['task_id'])) {
                                return 'Task #' . $properties['task_id'];
                            }

                            return 'Student Answer';
                        }

                        // For submitted_answer events, try to get the challenge name
                        if ($record->event === 'submitted_answer') {
                            // First try to get task_id from properties
                            $properties = $record->properties;
                            if (isset($properties['task_id'])) {
                                // Load the task with its challenge
                                $task = \App\Models\Task::with('challenge')->find($properties['task_id']);
                                if ($task && $task->challenge) {
                                    // Return the challenge name (subject name)
                                    return $task->challenge->name;
                                }
                                if ($task) {
                                    return $task->name;
                                }
                            }

                            // If subject is a StudentAnswer, try to get the task directly
                            if ($record->subject_type === 'App\\Models\\StudentAnswer' && $record->subject_id) {
                                $studentAnswer = \App\Models\StudentAnswer::with('task.challenge')->find($record->subject_id);
                                if ($studentAnswer && $studentAnswer->task && $studentAnswer->task->challenge) {
                                    return $studentAnswer->task->challenge->name;
                                }
                                if ($studentAnswer && $studentAnswer->task) {
                                    return $studentAnswer->task->name;
                                }
                            }

                            // If we have a task_id in properties but couldn't load the task
                            if (isset($properties['task_id'])) {
                                return 'Task #' . $properties['task_id'];
                            }

                            return 'Student Answer';
                        }

                        // Check if log_name is a model name (like "Challenge", "Task", etc.)
                        if (in_array($record->log_name, ['Challenge', 'Task', 'StudentAnswer', 'User', 'Learning Material'])) {
                            return $record->log_name;
                        }

                        // Fallback to a generic description
                        return $record->subject_type ? class_basename($record->subject_type) : 'Activity';
                    }),

                // User column - Shows the student name
                TextColumn::make('log_name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        // First check if log_name contains a user name (not a model name)
                        if (!in_array($state, ['Challenge', 'Task', 'StudentAnswer', 'User', 'Learning Material', 'default'])) {
                            // Check if it's not an event name
                            if (!in_array($state, ['created', 'updated', 'deleted', 'submitted_answer', 'answer_evaluated'])) {
                                return $state;
                            }
                        }

                        // If the subject is a StudentAnswer, try to get the student who submitted the answer
                        if ($record->subject_type === 'App\\Models\\StudentAnswer') {
                            // First try to get user_id from properties
                            $properties = $record->properties;
                            if (isset($properties['user_id'])) {
                                // Try to load the user
                                $user = \App\Models\User::find($properties['user_id']);
                                if ($user) {
                                    return $user->name;
                                }
                            }

                            // If not found in properties, try to load the StudentAnswer and get the user
                            if ($record->subject_id) {
                                $studentAnswer = \App\Models\StudentAnswer::with('user')->find($record->subject_id);
                                if ($studentAnswer && $studentAnswer->user) {
                                    return $studentAnswer->user->name;
                                }
                            }

                            // If still not found, try causer
                            if ($record->causer_type === 'App\\Models\\User') {
                                if (!$record->relationLoaded('causer')) {
                                    $record->load('causer');
                                }

                                if ($record->causer && $record->causer->name) {
                                    return $record->causer->name;
                                }
                            }

                            // If we have a user_id in properties, try to get the user name directly from the database
                            if (isset($properties['user_id'])) {
                                $user = \App\Models\User::find($properties['user_id']);
                                if ($user) {
                                    return $user->name;
                                }
                                return 'Student #' . $properties['user_id'];
                            }

                            // If we have a causer_id, try to get the user name
                            if ($record->causer_id) {
                                $user = \App\Models\User::find($record->causer_id);
                                if ($user) {
                                    return $user->name;
                                }
                                return 'Student #' . $record->causer_id;
                            }

                            return 'Unknown Student';
                        }

                        // For submitted_answer events, try to find the student who submitted
                        if ($record->event === 'submitted_answer') {
                            // First check properties
                            $properties = $record->properties;
                            if (isset($properties['user_id'])) {
                                $user = \App\Models\User::find($properties['user_id']);
                                if ($user) {
                                    return $user->name;
                                }
                                return 'Student #' . $properties['user_id'];
                            }

                            // If subject is a StudentAnswer, try to get the user directly
                            if ($record->subject_type === 'App\\Models\\StudentAnswer' && $record->subject_id) {
                                $studentAnswer = \App\Models\StudentAnswer::find($record->subject_id);
                                if ($studentAnswer && $studentAnswer->user_id) {
                                    $user = \App\Models\User::find($studentAnswer->user_id);
                                    if ($user) {
                                        return $user->name;
                                    }
                                    return 'Student #' . $studentAnswer->user_id;
                                }
                            }

                            // Then check causer
                            if ($record->causer_type === 'App\\Models\\User') {
                                if (!$record->relationLoaded('causer')) {
                                    $record->load('causer');
                                }

                                if ($record->causer && $record->causer->name) {
                                    return $record->causer->name;
                                }

                                if ($record->causer_id) {
                                    return 'Student #' . $record->causer_id;
                                }
                            }

                            return 'Unknown Student';
                        }

                        // If we have a causer that is a User, show their name
                        if ($record->causer_type === 'App\\Models\\User') {
                            // Try to load the causer relationship if it's not already loaded
                            if (!$record->relationLoaded('causer')) {
                                $record->load('causer');
                            }

                            if ($record->causer && $record->causer->name) {
                                return $record->causer->name;
                            }

                            return 'User #' . $record->causer_id;
                        }

                        return 'System';
                    }),

                TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable()
                    ->limit(50),

                TextColumn::make('event')
                    ->label('Action')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state): string => $state ? ucfirst($state) : 'Unknown')
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        'submitted_answer' => 'success',
                        'answer_evaluated' => 'info',
                        null => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),

                // Add a properties column to show additional details
                TextColumn::make('properties')
                    ->label('Details')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';

                        $output = [];
                        foreach ($state as $key => $value) {
                            if (is_array($value) || is_object($value)) {
                                $value = json_encode($value);
                            }
                            $output[] = "$key: $value";
                        }

                        return implode(', ', $output);
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Subject Type')
                    ->options(function () {
                        return Activity::distinct('log_name')->pluck('log_name', 'log_name')->toArray();
                    }),

                Tables\Filters\Filter::make('user_search')
                    ->form([
                        Forms\Components\TextInput::make('user_name')
                            ->label('User Name')
                            ->placeholder('Search by user name'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['user_name'],
                            function ($query, $userName) {
                                // Search in causer.name relationship
                                return $query->whereHas('causer', function ($q) use ($userName) {
                                    $q->where('name', 'like', "%{$userName}%");
                                })
                                // Or search in log_name for cases where user name is stored there
                                ->orWhere('log_name', 'like', "%{$userName}%");
                            }
                        );
                    }),

                Tables\Filters\SelectFilter::make('event')
                    ->label('Action Type')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'submitted_answer' => 'Submitted Answer',
                        'answer_evaluated' => 'Answer Evaluated',
                    ]),

                Tables\Filters\SelectFilter::make('subject_type')
                    ->label('Resource Type')
                    ->options(function () {
                        $types = Activity::distinct('subject_type')
                            ->whereNotNull('subject_type')
                            ->pluck('subject_type')
                            ->map(function ($type) {
                                return [
                                    'value' => $type,
                                    'label' => class_basename($type),
                                ];
                            })
                            ->pluck('label', 'value')
                            ->toArray();

                        return $types;
                    }),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn($query) => $query->whereDate('created_at', '>=', $data['created_from']),
                            )
                            ->when(
                                $data['created_until'],
                                fn($query) => $query->whereDate('created_at', '<=', $data['created_until']),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Created from ' . $data['created_from'];
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Created until ' . $data['created_until'];
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View')
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Activity Log')
                        ->modalDescription('Are you sure you want to delete this activity log? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete it')
                        ->modalCancelActionLabel('No, cancel'),
                ]),
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
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
            'edit' => Pages\EditActivityLog::route('/{record}/edit'),
        ];
    }
}
