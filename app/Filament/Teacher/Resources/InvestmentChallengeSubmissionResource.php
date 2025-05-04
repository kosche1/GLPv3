<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\InvestmentChallengeSubmissionResource\Pages;
use App\Models\UserInvestmentChallenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InvestmentChallengeSubmissionResource extends Resource
{
    protected static ?string $model = UserInvestmentChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'InvestSmart Submissions';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Submission Details')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->label('Student')
                            ->disabled(),
                        Forms\Components\TextInput::make('challenge.title')
                            ->label('Challenge')
                            ->disabled(),
                        Forms\Components\TextInput::make('status')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('submitted_at')
                            ->label('Submitted')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Student Submission')
                    ->schema([
                        Forms\Components\Textarea::make('strategy')
                            ->label('Investment Strategy')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('learnings')
                            ->label('Learnings & Reflections')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Teacher Evaluation')
                    ->schema([
                        Forms\Components\Select::make('grade')
                            ->label('Grade')
                            ->options([
                                'excellent' => 'Excellent',
                                'good' => 'Good',
                                'satisfactory' => 'Satisfactory',
                                'needs_improvement' => 'Needs Improvement',
                                'incomplete' => 'Incomplete',
                            ]),
                        Forms\Components\Textarea::make('feedback')
                            ->label('Feedback')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('points_awarded')
                            ->label('Award Points')
                            ->helperText('Toggle to award points to the student for this submission')
                            ->default(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('challenge.title')
                    ->label('Challenge')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in_progress' => 'warning',
                        'submitted' => 'info',
                        'completed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('progress')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'excellent' => 'success',
                        'good' => 'info',
                        'satisfactory' => 'warning',
                        'needs_improvement' => 'danger',
                        'incomplete' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('points_awarded')
                    ->boolean()
                    ->label('Points'),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'in_progress' => 'In Progress',
                        'submitted' => 'Submitted',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ]),
                Tables\Filters\SelectFilter::make('grade')
                    ->options([
                        'excellent' => 'Excellent',
                        'good' => 'Good',
                        'satisfactory' => 'Satisfactory',
                        'needs_improvement' => 'Needs Improvement',
                        'incomplete' => 'Incomplete',
                    ]),
                Tables\Filters\TernaryFilter::make('points_awarded')
                    ->label('Points Status')
                    ->placeholder('All Submissions')
                    ->trueLabel('Points Awarded')
                    ->falseLabel('Points Pending'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve & Award Points')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (UserInvestmentChallenge $record) => !$record->points_awarded && $record->status === 'submitted')
                    ->requiresConfirmation()
                    ->modalHeading('Approve InvestSmart Challenge')
                    ->modalDescription(fn (UserInvestmentChallenge $record) => "Are you sure you want to approve {$record->user->name}'s submission for challenge '{$record->challenge->title}'? This will award {$record->challenge->points_reward} points to the student.")
                    ->modalSubmitActionLabel('Yes, Approve Submission')
                    ->action(function (UserInvestmentChallenge $record) {
                        // Award points to the user
                        $user = $record->user;
                        $pointsToAward = $record->challenge->points_reward;

                        // Update the submission record
                        $record->points_awarded = true;
                        $record->points_awarded_at = now();
                        $record->approved_by = Auth::id();
                        $record->status = 'completed';
                        $record->save();

                        // Award the points
                        $user->addPoints(
                            amount: $pointsToAward,
                            reason: "InvestSmart challenge completed: {$record->challenge->title}"
                        );

                        // Show notification in the bell and persist it
                        Notification::make()
                            ->success()
                            ->title('Points Awarded')
                            ->body("Awarded {$pointsToAward} points to {$user->name} for completing the InvestSmart challenge '{$record->challenge->title}'")
                            ->persistent()
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('view')
                                    ->button()
                                    ->url(route('filament.teacher.resources.investment-challenge-submissions.edit', $record))
                            ])
                            ->send();

                        // Show a popup notification that stays longer
                        Notification::make('investsmart-approval-success')
                            ->success()
                            ->title('Challenge Submission Approved!')
                            ->body("You have approved {$user->name}'s submission for challenge '{$record->challenge->title}' and awarded {$pointsToAward} points.")
                            ->duration(15000) // Show for 15 seconds
                            ->icon('heroicon-o-check-circle')
                            ->iconColor('success')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approveMultiple')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Approve Selected Submissions')
                        ->modalDescription('Are you sure you want to approve all selected InvestSmart challenge submissions? This will award points to the students.')
                        ->modalSubmitActionLabel('Yes, Approve All Selected')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = 0;
                            $totalPoints = 0;

                            foreach ($records as $record) {
                                if (!$record->points_awarded && $record->status === 'submitted') {
                                    $user = $record->user;
                                    $pointsToAward = $record->challenge->points_reward;

                                    // Update the submission record
                                    $record->points_awarded = true;
                                    $record->points_awarded_at = now();
                                    $record->approved_by = Auth::id();
                                    $record->status = 'completed';
                                    $record->save();

                                    // Award the points
                                    $user->addPoints(
                                        amount: $pointsToAward,
                                        reason: "InvestSmart challenge completed: {$record->challenge->title}"
                                    );

                                    $count++;
                                    $totalPoints += $pointsToAward;
                                }
                            }

                            if ($count > 0) {
                                // Persistent notification for the bell
                                Notification::make()
                                    ->success()
                                    ->title('Submissions Approved')
                                    ->body("Approved {$count} submissions and awarded a total of {$totalPoints} points")
                                    ->persistent()
                                    ->send();

                                // Popup notification that stays longer
                                Notification::make('investsmart-bulk-approval-success')
                                    ->success()
                                    ->title('Challenge Submissions Approved!')
                                    ->body("You have approved {$count} challenge submissions and awarded a total of {$totalPoints} points to students.")
                                    ->duration(15000) // Show for 15 seconds
                                    ->icon('heroicon-o-check-circle')
                                    ->iconColor('success')
                                    ->send();
                            } else {
                                // Persistent notification for the bell
                                Notification::make()
                                    ->warning()
                                    ->title('No Submissions Approved')
                                    ->body("No submissions were eligible for approval")
                                    ->persistent()
                                    ->send();

                                // Popup notification that stays longer
                                Notification::make('investsmart-bulk-approval-warning')
                                    ->warning()
                                    ->title('No Submissions Approved')
                                    ->body("No submissions were eligible for approval. Make sure you've selected submissions that haven't been approved yet.")
                                    ->duration(15000) // Show for 15 seconds
                                    ->icon('heroicon-o-exclamation-triangle')
                                    ->iconColor('warning')
                                    ->send();
                            }
                        }),
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
            'index' => Pages\ListInvestmentChallengeSubmissions::route('/'),
            'edit' => Pages\EditInvestmentChallengeSubmission::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['user', 'challenge']);

        // Filter by challenge_id if provided in the URL
        if (request()->has('challenge_id')) {
            $query->where('investment_challenge_id', request()->challenge_id);
        }

        return $query;
    }
}
