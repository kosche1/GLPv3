<?php

namespace App\Filament\Teacher\Resources\StudentAnswerResource;

use App\Models\StudentAnswer;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Filament\Support\Contracts\TranslatableContentDriver;
use Illuminate\Support\Facades\Auth;

class ListStudentAnswers extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;

    // Add missing property
    protected bool $isCachingForms = false;

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public $status;

    public function mount($status = null)
    {
        $this->status = $status;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                StudentAnswer::query()
                    ->when($this->status, fn (Builder $query) => $query->where('status', $this->status))
                    ->latest()
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable(),
                TextColumn::make('task.name')
                    ->label('Task')
                    ->searchable(),
                IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean(),
                TextColumn::make('score')
                    ->label('Score'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted' => 'gray',
                        'pending_manual_evaluation' => 'warning',
                        'evaluated' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('evaluated_at')
                    ->label('Evaluated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Action::make('evaluate')
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

                        Notification::make()
                            ->title('Student answer evaluated successfully')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (StudentAnswer $record) => $record->status !== 'evaluated'),

                Action::make('view')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->url(fn (StudentAnswer $record) => route('filament.admin.resources.student-answers.view', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ]);
    }

    public function render()
    {
        return view('livewire.filament.teacher.resources.student-answer-resource.list-student-answers');
    }
}
