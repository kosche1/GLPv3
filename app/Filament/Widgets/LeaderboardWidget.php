<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LeaderboardWidget extends BaseWidget
{
    protected int|string|array $columnSpan = "full";

    protected static ?int $sort = 2;

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return "points";
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return "desc";
    }

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->join("experiences", "users.id", "=", "experiences.user_id")
            ->select("users.*", "experiences.points", "experiences.level_id")
            ->orderBy("experiences.points", "desc");
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make("id")
                ->label("Rank")
                ->getStateUsing(static function ($rowLoop): string {
                    return (string) $rowLoop->iteration;
                }),
            Tables\Columns\TextColumn::make("name")->searchable(),
            Tables\Columns\TextColumn::make("points")
                ->label("XP Points")
                ->sortable(),
            Tables\Columns\TextColumn::make("level.level")
                ->label("Level")
                ->sortable(),
            Tables\Columns\TextColumn::make("achievements_count")
                ->counts("achievements")
                ->label("Achievements"),
            Tables\Columns\TextColumn::make("badges_count")
                ->counts("badges")
                ->label("Badges"),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make("view")
                ->url(
                    fn(User $record): string => route(
                        "filament.resources.user-stats.view",
                        $record
                    )
                )
                ->icon("heroicon-s-eye"),
        ];
    }
}
