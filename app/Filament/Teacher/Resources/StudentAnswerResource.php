<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\StudentAnswerResource\Pages;
use App\Models\StudentAnswer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Actions\Action;

class StudentAnswerResource extends Resource
{
    protected static ?string $model = StudentAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'Student Answers';
    protected static ?string $navigationGroup = 'Assessment';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false; // Hide from navigation, we'll use the Assessment Tools page instead

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Submission Details')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->disabled()
                        ->required(),
                    Forms\Components\Select::make('task_id')
                        ->relationship('task', 'name')
                        ->disabled()
                        ->required(),
                    Forms\Components\Textarea::make('submitted_text')
                        ->label('Submitted Text')
                        ->rows(5)
                        ->columnSpanFull()
                        ->disabled(),
                    Forms\Components\TextInput::make('submitted_file_path')
                         ->label('Submitted File')
                         ->columnSpan(1)
                         ->disabled()
                         ->suffixAction(
                             fn (?string $state): Action =>
                                 Action::make('download_file')
                                     ->icon('heroicon-s-arrow-down-tray')
                                     ->url(fn () => Storage::url($state), shouldOpenInNewTab: true)
                                     ->visible(fn (?string $state): bool => filled($state) && Storage::exists($state)),
                         ),
                    Forms\Components\TextInput::make('submitted_url')
                         ->label('Submitted URL')
                         ->columnSpan(1)
                         ->disabled()
                         ->suffixAction(
                             fn (?string $state): Action =>
                                Action::make('visit_url')
                                    ->icon('heroicon-s-arrow-top-right-on-square')
                                    ->url($state, shouldOpenInNewTab: true)
                                    ->visible(fn (?string $state): bool => filled($state)),
                         ),
                     Forms\Components\KeyValue::make('submitted_data')
                         ->label('Submitted Data (JSON)')
                         ->columnSpanFull()
                         ->disabled(),
                     Forms\Components\Placeholder::make('status_current')
                        ->label('Current Status')
                        ->content(fn (StudentAnswer $record): string => ucfirst(str_replace('_', ' ', $record->status ?? 'N/A'))),
                ])->collapsible(),

            Forms\Components\Section::make('Manual Review')
                ->visible(fn (StudentAnswer $record): bool => $record->task?->evaluation_type === 'manual' && $record->status === 'pending_manual_evaluation')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_correct')
                        ->label('Is Correct?')
                        ->required()
                        ->afterStateUpdated(function ($state, callable $set) {
                            // If marked as correct, set status to 'evaluated'
                            if ($state) {
                                $set('status', 'evaluated');
                            }
                        }),
                    Forms\Components\TextInput::make('score')
                        ->label('Score Awarded')
                        ->numeric()
                        ->helperText(fn(StudentAnswer $record) => 'Max score for this task: ' . $record->task?->points_reward)
                        ->minValue(0)
                        ->required(),
                    Forms\Components\Textarea::make('feedback')
                        ->label('Feedback for Student')
                        ->rows(4)
                        ->columnSpanFull(),
                    Forms\Components\Hidden::make('status')
                        ->default('evaluated'),
                    Forms\Components\Hidden::make('evaluated_at')
                        ->default(now()->toDateTimeString()),
                    // We'll set evaluated_by in the afterSave hook
                    Forms\Components\Placeholder::make('evaluated_at_info')
                        ->label('Evaluated At')
                        ->content(fn (StudentAnswer $record): ?string => $record->evaluated_at?->diffForHumans() . ' (' . $record->evaluated_at?->format('Y-m-d H:i') . ')')
                        ->visible(fn (StudentAnswer $record): bool => !empty($record->evaluated_at)),
                     Forms\Components\Placeholder::make('evaluated_by_info')
                        ->label('Evaluated By')
                        ->content(fn (StudentAnswer $record): ?string => $record->evaluator?->name)
                        ->visible(fn (StudentAnswer $record): bool => !empty($record->evaluated_by)),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('task.name')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                 Tables\Columns\TextColumn::make('task.evaluation_type')
                    ->label('Evaluation Type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted' => 'warning',
                        'pending_manual_evaluation' => 'info',
                        'evaluated' => 'success',
                        'evaluation_error' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->sortable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('evaluated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('evaluator.name')
                    ->label('Evaluated By')
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                 Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                 Filter::make('needs_manual_review')
                    ->label('Needs Manual Review')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'pending_manual_evaluation'))
                    ->default(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'pending_manual_evaluation' => 'Pending Manual Evaluation',
                        'evaluated' => 'Evaluated',
                        'evaluation_error' => 'Evaluation Error',
                    ])->multiple(),
                Tables\Filters\SelectFilter::make('task_evaluation_type')
                    ->label('Task Evaluation Type')
                    ->relationship('task', 'evaluation_type', fn (Builder $query) => $query->selectRaw('DISTINCT evaluation_type')->whereNotNull('evaluation_type'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => ucfirst($record?->evaluation_type ?? 'Unknown')),
                Tables\Filters\TernaryFilter::make('is_correct')
                    ->label('Correct Answers'),
            ], layout: FiltersLayout::AboveContent)
             ->persistFiltersInSession()
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Review / Edit'),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListStudentAnswers::route('/'),
            'edit' => Pages\EditStudentAnswer::route('/{record}/edit'),
        ];
    }
}
