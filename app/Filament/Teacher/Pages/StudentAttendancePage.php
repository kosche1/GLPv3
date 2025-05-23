<?php

namespace App\Filament\Teacher\Pages;

use App\Models\AuditTrail;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Writer;

class StudentAttendancePage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?string $navigationLabel = 'Audit Trail';

    protected static ?string $title = 'Audit Trails';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.teacher.pages.student-attendance';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AuditTrail::query()
                    ->whereHas('user', function (Builder $query) {
                        $query->role('student');
                    })
            )
            ->defaultPaginationPageOption(25)
            ->poll('60s')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('action_type')
                    ->label('Action Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'registration' => 'success',
                        'login' => 'primary',
                        'logout' => 'purple',
                        'challenge_completion' => 'info',
                        'task_submission' => 'warning',
                        'task_evaluation' => 'danger',
                        'challenge_creation' => 'gray',
                        'task_creation' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'registration' => 'Registration',
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'challenge_completion' => 'Challenge Completion',
                        'task_submission' => 'Task Submission',
                        'task_evaluation' => 'Task Evaluation',
                        'challenge_creation' => 'Challenge Creation',
                        'task_creation' => 'Task Creation',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject_type')
                    ->label('Subject Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject_name')
                    ->label('Subject Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('challenge_name')
                    ->label('Challenge')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('task_name')
                    ->label('Task')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('score')
                    ->label('Score')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('effective_timestamp')
                    ->label('Date & Time')
                    ->dateTime('F j, Y g:i:s A')
                    ->timezone(config('app.timezone'))
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('created_at', $direction);
                    }),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('action_type')
                    ->label('Action Type')
                    ->options([
                        'registration' => 'Registration',
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'challenge_completion' => 'Challenge Completion',
                        'task_submission' => 'Task Submission',
                        'task_evaluation' => 'Task Evaluation',
                        'challenge_creation' => 'Challenge Creation',
                        'task_creation' => 'Task Creation',
                    ]),

                \Filament\Tables\Filters\SelectFilter::make('subject_type')
                    ->label('Subject Type')
                    ->options([
                        'Core' => 'Core',
                        'Applied' => 'Applied',
                        'Specialized' => 'Specialized',
                    ]),

                \Filament\Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        \Filament\Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                \Filament\Tables\Filters\SelectFilter::make('user_id')
                    ->label('Student')
                    ->relationship('user', 'name', fn (Builder $query) => $query->role('student'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                \Filament\Tables\Actions\ViewAction::make()
                    ->url(fn (AuditTrail $record): string => route('audit-trails.print-view', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkAction::make('export')
                    ->label('Export Selected')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function (Collection $records): StreamedResponse {
                        $csv = Writer::createFromString();

                        // Add the headers
                        $csv->insertOne([
                            'ID',
                            'Student Name',
                            'Action Type',
                            'Subject Type',
                            'Subject Name',
                            'Challenge Name',
                            'Task Name',
                            'Score',
                            'Description',
                            'Date & Time',
                        ]);

                        // Add the records
                        $records->each(function (AuditTrail $record) use ($csv) {
                            $csv->insertOne([
                                $record->id,
                                $record->user->name,
                                $record->action_type,
                                $record->subject_type,
                                $record->subject_name,
                                $record->challenge_name,
                                $record->task_name,
                                $record->score,
                                $record->description,
                                $record->created_at->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'),
                            ]);
                        });

                        return response()->streamDownload(
                            fn () => print($csv->toString()),
                            'student-activity-export-' . now()->setTimezone(config('app.timezone'))->format('Y-m-d_H-i-s') . '.csv',
                            [
                                'Content-Type' => 'text/csv',
                            ]
                        );
                    })
            ])
            ->defaultSort('created_at', 'desc');
    }
}
