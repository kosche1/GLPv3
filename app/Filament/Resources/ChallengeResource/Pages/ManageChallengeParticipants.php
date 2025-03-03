<?php

namespace App\Filament\Resources\ChallengeResource\Pages;

use App\Filament\Resources\ChallengeResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageChallengeParticipants extends Page
{
    protected static string $resource = ChallengeResource::class;

    protected static string $view = "filament.resources.challenge-resource.pages.manage-challenge-participants";

    public $challenge;

    public function mount($record): void
    {
        $this->challenge = $this->resolveRecord($record);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::whereHas("challenges", function (Builder $query) {
                    $query->where("challenge_id", $this->challenge->id);
                })
            )
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("email")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("challenges.pivot.status")
                    ->label("Status")
                    ->getStateUsing(function (User $record) {
                        return $record
                            ->challenges()
                            ->where("challenge_id", $this->challenge->id)
                            ->first()?->pivot?->status;
                    })
                    ->badge()
                    ->color(
                        fn(string $state): string => match ($state) {
                            "enrolled" => "gray",
                            "in_progress" => "warning",
                            "completed" => "success",
                            "failed" => "danger",
                            default => "gray",
                        }
                    ),
                Tables\Columns\TextColumn::make("challenges.pivot.progress")
                    ->label("Progress")
                    ->getStateUsing(function (User $record) {
                        return $record
                            ->challenges()
                            ->where("challenge_id", $this->challenge->id)
                            ->first()?->pivot?->progress . "%";
                    }),
                Tables\Columns\TextColumn::make("challenges.pivot.completed_at")
                    ->label("Completed At")
                    ->dateTime()
                    ->getStateUsing(function (User $record) {
                        return $record
                            ->challenges()
                            ->where("challenge_id", $this->challenge->id)
                            ->first()?->pivot?->completed_at;
                    }),
                Tables\Columns\IconColumn::make(
                    "challenges.pivot.reward_claimed"
                )
                    ->label("Reward Claimed")
                    ->boolean()
                    ->getStateUsing(function (User $record) {
                        return $record
                            ->challenges()
                            ->where("challenge_id", $this->challenge->id)
                            ->first()?->pivot?->reward_claimed;
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("status")
                    ->options([
                        "enrolled" => "Enrolled",
                        "in_progress" => "In Progress",
                        "completed" => "Completed",
                        "failed" => "Failed",
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (isset($data["value"])) {
                            $query->whereHas("challenges", function (
                                Builder $q
                            ) use ($data) {
                                $q->where(
                                    "challenge_id",
                                    $this->challenge->id
                                )->where("status", $data["value"]);
                            });
                        }
                    }),
                Tables\Filters\Filter::make("reward_claimed")
                    ->label("Reward Claimed")
                    ->query(function (Builder $query, array $data) {
                        if (isset($data["value"])) {
                            $query->whereHas("challenges", function (
                                Builder $q
                            ) use ($data) {
                                $q->where(
                                    "challenge_id",
                                    $this->challenge->id
                                )->where("reward_claimed", $data["value"]);
                            });
                        }
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make("add_participant")
                    ->label("Add Participant")
                    ->form([
                        Select::make("user_id")
                            ->label("User")
                            ->required()
                            ->options(function () {
                                // Get users who are not already participants
                                $existingParticipantIds = $this->challenge
                                    ->users()
                                    ->pluck("user_id")
                                    ->toArray();
                                return User::whereNotIn(
                                    "id",
                                    $existingParticipantIds
                                )
                                    ->pluck("name", "id")
                                    ->toArray();
                            })
                            ->searchable(),
                    ])
                    ->action(function (array $data): void {
                        $this->challenge->users()->attach($data["user_id"], [
                            "status" => "enrolled",
                            "progress" => 0,
                        ]);

                        $this->notify(
                            "success",
                            "User added to challenge successfully"
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make("update_status")
                    ->label("Update Status")
                    ->icon("heroicon-o-pencil")
                    ->form([
                        Forms\Components\Select::make("status")
                            ->label("Status")
                            ->options([
                                "enrolled" => "Enrolled",
                                "in_progress" => "In Progress",
                                "completed" => "Completed",
                                "failed" => "Failed",
                            ])
                            ->required(),
                        Forms\Components\TextInput::make("progress")
                            ->label("Progress")
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix("%")
                            ->required(),
                        Forms\Components\Toggle::make("reward_claimed")
                            ->label("Reward Claimed")
                            ->default(false),
                    ])
                    ->action(function (User $record, array $data): void {
                        $completedAt = null;
                        $rewardClaimedAt = null;

                        if (
                            $data["status"] === "completed" &&
                            $data["progress"] === 100
                        ) {
                            $completedAt = now();
                        }

                        if ($data["reward_claimed"]) {
                            $rewardClaimedAt = now();
                        }

                        $record
                            ->challenges()
                            ->updateExistingPivot($this->challenge->id, [
                                "status" => $data["status"],
                                "progress" => $data["progress"],
                                "completed_at" => $completedAt,
                                "reward_claimed" => $data["reward_claimed"],
                                "reward_claimed_at" => $rewardClaimedAt,
                            ]);

                        $this->notify(
                            "success",
                            "Participant status updated successfully"
                        );
                    }),
                Tables\Actions\Action::make("remove")
                    ->label("Remove")
                    ->icon("heroicon-o-trash")
                    ->color("danger")
                    ->requiresConfirmation()
                    ->action(function (User $record): void {
                        $record->challenges()->detach($this->challenge->id);
                        $this->notify(
                            "success",
                            "Participant removed from challenge"
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make("update_multiple_status")
                    ->label("Update Status")
                    ->icon("heroicon-o-pencil")
                    ->form([
                        Forms\Components\Select::make("status")
                            ->label("Status")
                            ->options([
                                "enrolled" => "Enrolled",
                                "in_progress" => "In Progress",
                                "completed" => "Completed",
                                "failed" => "Failed",
                            ])
                            ->required(),
                    ])
                    ->action(function (
                        \Illuminate\Database\Eloquent\Collection $records,
                        array $data
                    ): void {
                        foreach ($records as $record) {
                            $completedAt = null;

                            if ($data["status"] === "completed") {
                                $completedAt = now();
                            }

                            $record
                                ->challenges()
                                ->updateExistingPivot($this->challenge->id, [
                                    "status" => $data["status"],
                                    "completed_at" => $completedAt,
                                ]);
                        }

                        $this->notify(
                            "success",
                            "Selected participants updated successfully"
                        );
                    }),
                Tables\Actions\BulkAction::make("remove_multiple")
                    ->label("Remove Selected")
                    ->icon("heroicon-o-trash")
                    ->color("danger")
                    ->requiresConfirmation()
                    ->action(function (
                        \Illuminate\Database\Eloquent\Collection $records
                    ): void {
                        foreach ($records as $record) {
                            $record->challenges()->detach($this->challenge->id);
                        }

                        // $this->notify(
                        //     "success",
                        //     "Selected participants removed from challenge"
                        // );
                    }),
            ]);
    }
}
