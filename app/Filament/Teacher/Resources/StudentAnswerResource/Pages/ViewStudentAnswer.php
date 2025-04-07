<?php

namespace App\Filament\Teacher\Resources\StudentAnswerResource\Pages;

use App\Filament\Teacher\Resources\StudentAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentAnswer extends ViewRecord
{
    protected static string $resource = StudentAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('evaluate')
                ->label('Evaluate')
                ->icon('heroicon-o-pencil')
                ->form([
                    \Filament\Forms\Components\Toggle::make('is_correct')
                        ->label('Is Correct?')
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('score')
                        ->label('Score')
                        ->numeric()
                        ->required(),
                    \Filament\Forms\Components\Textarea::make('feedback')
                        ->label('Feedback')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'is_correct' => $data['is_correct'],
                        'score' => $data['score'],
                        'feedback' => $data['feedback'],
                        'status' => 'evaluated',
                        'evaluated_at' => now(),
                        'evaluated_by' => auth()->id() ?? 1,
                    ]);

                    // Award points if correct
                    if ($data['is_correct'] && $this->record->task) {
                        $user = $this->record->user;
                        if ($user) {
                            $user->givePoints($this->record->task->points_reward, "Completed task: {$this->record->task->name}");
                        }
                    }
                })
                ->visible(fn () => $this->record->status !== 'evaluated'),
        ];
    }
}
