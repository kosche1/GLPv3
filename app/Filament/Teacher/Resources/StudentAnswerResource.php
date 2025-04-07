<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\StudentAnswerResource\Pages;
use App\Models\StudentAnswer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StudentAnswerResource extends Resource
{
    protected static ?string $model = StudentAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Student Answers';
    protected static ?string $navigationGroup = 'Assessment';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false; // Hide from navigation, we'll use the Assessment Tools page instead

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Evaluation')
                    ->schema([
                        Forms\Components\Toggle::make('is_correct')
                            ->label('Is Correct?')
                            ->required(),
                        Forms\Components\TextInput::make('score')
                            ->label('Score')
                            ->numeric()
                            ->required(),
                        Forms\Components\Textarea::make('feedback')
                            ->label('Feedback')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable(),
                Tables\Columns\TextColumn::make('task.name')
                    ->label('Task')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted' => 'gray',
                        'pending_manual_evaluation' => 'warning',
                        'evaluated' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('evaluated_at')
                    ->label('Evaluated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'pending_manual_evaluation' => 'Pending Review',
                        'evaluated' => 'Evaluated',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('evaluate')
                    ->label('Evaluate')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        Forms\Components\Toggle::make('is_correct')
                            ->label('Is Correct?')
                            ->required(),
                        Forms\Components\TextInput::make('score')
                            ->label('Score')
                            ->numeric()
                            ->required(),
                        Forms\Components\Textarea::make('feedback')
                            ->label('Feedback')
                            ->required(),
                    ])
                    ->action(function (array $data, StudentAnswer $record): void {
                        $record->update([
                            'is_correct' => $data['is_correct'],
                            'score' => $data['score'],
                            'feedback' => $data['feedback'],
                            'status' => 'evaluated',
                            'evaluated_at' => now(),
                            'evaluated_by' => Auth::id() ?? 1,
                        ]);

                        // Award points if correct
                        if ($data['is_correct'] && $record->task) {
                            $user = $record->user;
                            if ($user) {
                                $user->givePoints($record->task->points_reward, "Completed task: {$record->task->name}");
                            }
                        }
                    })
                    ->visible(fn (StudentAnswer $record) => $record->status !== 'evaluated'),

                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentAnswers::route('/'),
            'view' => Pages\ViewStudentAnswer::route('/{record}'),
        ];
    }
}
