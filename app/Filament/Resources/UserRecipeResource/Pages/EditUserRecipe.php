<?php

namespace App\Filament\Resources\UserRecipeResource\Pages;

use App\Filament\Resources\UserRecipeResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditUserRecipe extends EditRecord
{
    protected static string $resource = UserRecipeResource::class;

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
            $pointsToAward = $record->potential_points;

            // Update additional fields
            $record->points_awarded_at = now();
            $record->approved_by = Auth::id();
            $record->saveQuietly(); // Save without triggering observers again

            // Award the points
            $user->addPoints(
                amount: $pointsToAward,
                reason: "Recipe approved: {$record->name}"
            );

            // Show notification in the bell and persist it
            Notification::make()
                ->success()
                ->title('Points Awarded')
                ->body("Awarded {$pointsToAward} points to {$user->name} for recipe {$record->name}")
                ->persistent()
                ->actions([
                    \Filament\Notifications\Actions\Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.user-recipes.edit', $record))
                ])
                ->send();

            // Show a popup notification that stays longer
            Notification::make('admin-edit-approval-success')
                ->success()
                ->title('Recipe Approved Successfully!')
                ->body("You have approved {$record->name} by {$user->name} and awarded {$pointsToAward} points.")
                ->duration(15000) // Show for 15 seconds
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->send();
        }
    }
}
