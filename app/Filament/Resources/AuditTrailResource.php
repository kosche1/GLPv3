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
                                'challenge_completion' => 'Challenge Completion',
                                'task_submission' => 'Task Submission',
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
                        'challenge_completion' => 'primary',
                        'task_submission' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'registration' => 'Registration',
                        'challenge_completion' => 'Challenge Completion',
                        'task_submission' => 'Task Submission',
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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date & Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action_type')
                    ->label('Action Type')
                    ->options([
                        'registration' => 'Registration',
                        'challenge_completion' => 'Challenge Completion',
                        'task_submission' => 'Task Submission',
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
                    ->url(fn (AuditTrail $record) => route('filament.admin.resources.audit-trails.print', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // No bulk actions needed
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
        ];
    }
}
