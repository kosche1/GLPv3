<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use App\Models\StudentAnswer;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;

class AssessmentTools extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Assessment Tools';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Teaching';

    protected static string $view = 'filament.teacher.pages.assessment-tools';

    public function getTitle(): string
    {
        return 'Assessment Tools';
    }

    public function getSubheading(): ?string
    {
        return 'Evaluate student submissions and provide feedback';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentAnswer::query())
            ->defaultSort('created_at', 'desc')
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
            ])
            ->filters([
                Tables\Filters\Filter::make('needs_manual_review')
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
                Tables\Actions\Action::make('evaluate')
                    ->label('Evaluate')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (StudentAnswer $record): string => route('filament.teacher.resources.student-answers.edit', ['record' => $record]))
                    ->visible(fn (StudentAnswer $record) => $record->status === 'pending_manual_evaluation'),
                Tables\Actions\ViewAction::make()
                    ->url(fn (StudentAnswer $record): string => route('filament.teacher.resources.student-answers.edit', ['record' => $record])),
            ])
            ->bulkActions([]);
    }
}
