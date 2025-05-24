<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LeaderboardWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Student Leaderboard';

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'experience_points';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->role('student')
                    ->join('experiences', 'users.id', '=', 'experiences.user_id')
                    ->select('users.*', 'experiences.experience_points', 'experiences.level_id')
                    ->selectSub(function ($query) {
                        $query->select('created_at')
                            ->from('experience_audits')
                            ->whereColumn('experience_audits.user_id', 'users.id')
                            ->where('experience_audits.type', 'add')
                            ->where('experience_audits.points', '>', 0)
                            ->orderBy('created_at', 'desc')
                            ->limit(1);
                    }, 'last_points_earned_at')
                    ->selectSub(function ($query) {
                        $query->select('points')
                            ->from('experience_audits')
                            ->whereColumn('experience_audits.user_id', 'users.id')
                            ->where('experience_audits.type', 'add')
                            ->where('experience_audits.points', '>', 0)
                            ->orderBy('created_at', 'desc')
                            ->limit(1);
                    }, 'last_points_earned')
                    ->orderBy('experiences.experience_points', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Rank')
                    ->getStateUsing(static function ($rowLoop): string {
                        return (string) $rowLoop->iteration;
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('experience_points')
                    ->label('XP Points')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level_id')
                    ->label('Level')
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_points_earned_at')
                    ->label('Last Points Earned')
                    ->formatStateUsing(function ($record) {
                        if (!$record->last_points_earned_at) {
                            return 'No points earned yet';
                        }
                        $date = \Carbon\Carbon::parse($record->last_points_earned_at)->format('M j, Y');
                        $points = $record->last_points_earned ?? 0;
                        return $points > 0 ? "{$date} (+{$points} XP)" : $date;
                    })
                    ->sortable()
                    ->html(),
                Tables\Columns\TextColumn::make('studentAnswers_count')
                    ->label('Completed Tasks')
                    ->counts('studentAnswers', fn (Builder $query) => $query->where('is_correct', true))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->paginated(true);
    }
}
