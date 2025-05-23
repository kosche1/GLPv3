<?php

namespace App\Filament\Teacher\Resources\StudentAnswerResource\Pages;

use App\Filament\Teacher\Resources\StudentAnswerResource;
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

                // Make sure notification_shown is set to false to trigger the modal
                $record->notification_shown = false;
                $record->saveQuietly(); // Save without triggering observers again

                // Show a notification to the admin
                Notification::make()
                    ->success()
                    ->title('Points awarded')
                    ->body("Points have been awarded to {$user->name} for completing task {$task->name}")
                    ->send();

                // Record this action in the audit trail
                try {
                    \App\Models\AuditTrail::recordTaskEvaluation(
                        Auth::user(),
                        $record,
                        [
                            'points_awarded' => $task->points_reward,
                            'task_id' => $task->id,
                        ]
                    );
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error recording task evaluation in audit trail: ' . $e->getMessage());
                }
            }
        }
    }
}
