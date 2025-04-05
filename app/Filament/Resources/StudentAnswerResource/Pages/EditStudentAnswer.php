<?php

namespace App\Filament\Resources\StudentAnswerResource\Pages;

use App\Filament\Resources\StudentAnswerResource;
use App\Models\Experience;
use App\Models\StudentAnswer;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditStudentAnswer extends EditRecord
{
    protected static string $resource = StudentAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        /** @var StudentAnswer $record */
        $record = $this->record;

        // Set the evaluator ID
        if ($record->status === 'evaluated' && empty($record->evaluated_by)) {
            $record->evaluated_by = Auth::id();
            $record->saveQuietly(); // Save without triggering observers again
        }

        // Award points if the answer is marked as correct
        if ($record->is_correct && $record->status === 'evaluated') {
            $user = $record->user;
            $task = $record->task;

            if ($user && $task) {
                // Award experience points
                Experience::awardTaskPoints($user, $task);

                // Mark the task as completed in the user_tasks pivot table
                $user->tasks()->syncWithoutDetaching([
                    $task->id => [
                        'completed' => true,
                        'completed_at' => now(),
                        'progress' => 100,
                    ]
                ]);

                // Show a notification
                Notification::make()
                    ->success()
                    ->title('Points awarded')
                    ->body("Points have been awarded to {$user->name} for completing task {$task->name}")
                    ->send();
            }
        }
    }
}
