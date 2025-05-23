<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditTrailResource\Pages;
use App\Models\AuditTrail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Writer;

class AuditTrailResource extends Resource
{
    protected static ?string $model = AuditTrail::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Audit Trail';

    protected static ?int $navigationSort = 90;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Activity Details')
                    ->schema([
                        Forms\Components\Select::make('action_type')
                            ->options([
                                'registration' => 'Registration',
                                'login' => 'Login',
                                'logout' => 'Logout',
                                'challenge_completion' => 'Challenge Completion',
                                'task_submission' => 'Task Submission',
                                'task_evaluation' => 'Task Evaluation',
                                'challenge_creation' => 'Challenge Creation',
                                'task_creation' => 'Task Creation',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('subject_type')
                            ->label('Subject Type')
                            ->placeholder('Core, Applied, or Specialized'),

                        Forms\Components\TextInput::make('subject_name')
                            ->label('Subject Name')
                            ->placeholder('e.g., Python, Math'),

                        Forms\Components\TextInput::make('challenge_name')
                            ->label('Challenge Name'),

                        Forms\Components\TextInput::make('task_name')
                            ->label('Task Name'),

                        Forms\Components\TextInput::make('score')
                            ->label('Score')
                            ->numeric(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required(),

                        Forms\Components\KeyValue::make('additional_data')
                            ->label('Additional Data'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('action_type')
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

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Subject Type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject_name')
                    ->label('Subject Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('challenge_name')
                    ->label('Challenge')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('task_name')
                    ->label('Task')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('effective_timestamp')
                    ->label('Date & Time')
                    ->dateTime('F j, Y g:i:s A')
                    ->timezone(config('app.timezone'))
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('created_at', $direction);
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action_type')
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

                Tables\Filters\SelectFilter::make('subject_type')
                    ->label('Subject Type')
                    ->options([
                        'Core' => 'Core',
                        'Applied' => 'Applied',
                        'Specialized' => 'Specialized',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('created_until')
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn (AuditTrail $record) => route('audit-trails.print-view', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('print')
                    ->label('Print Selected')
                    ->icon('heroicon-o-printer')
                    ->action(function (Collection $records) {
                        // Generate a unique ID for this batch
                        $batchId = uniqid('batch-');

                        // Store the records in the session
                        session()->put("audit-trail-print-{$batchId}", $records->pluck('id')->toArray());

                        // Redirect to the bulk print page
                        return redirect()->route('audit-trails.bulk-print-view', ['batchId' => $batchId]);
                    }),
                Tables\Actions\BulkAction::make('export')
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
                                'audit-trail-export-' . now()->setTimezone(config('app.timezone'))->format('Y-m-d_H-i-s') . '.csv',
                                [
                                    'Content-Type' => 'text/csv',
                                ]
                            );
                        })
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
            'index' => Pages\ListAuditTrails::route('/'),
            'view' => Pages\ViewAuditTrail::route('/{record}'),
            'edit' => Pages\EditAuditTrail::route('/{record}/edit'),
            'print' => Pages\PrintAuditTrail::route('/{record}/print'),
            'bulk-print' => Pages\BulkPrintAuditTrail::route('/bulk-print/{batchId}'),
        ];
    }
}
