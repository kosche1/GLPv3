<?php

namespace App\Filament\Resources\InvestmentChallengeSubmissionResource\Pages;

use App\Filament\Resources\InvestmentChallengeSubmissionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditInvestmentChallengeSubmission extends EditRecord
{
    protected static string $resource = InvestmentChallengeSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        // If points were awarded, update the record and award points
        if ($record->points_awarded && $record->getOriginal('points_awarded') === false) {
            $user = $record->user;
            $pointsToAward = $record->challenge->points_reward;

            // Update additional fields
            $record->points_awarded_at = now();
            $record->approved_by = Auth::id();
            $record->status = 'completed';
            $record->saveQuietly(); // Save without triggering observers again

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
                        ->url(route('filament.admin.resources.investment-challenge-submissions.edit', $record))
                ])
                ->send();

            // Show a popup notification that stays longer
            Notification::make('admin-investsmart-edit-approval-success')
                ->success()
                ->title('Challenge Submission Approved!')
                ->body("You have approved {$user->name}'s submission for challenge '{$record->challenge->title}' and awarded {$pointsToAward} points.")
                ->duration(15000) // Show for 15 seconds
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->send();
        }
    }
}
