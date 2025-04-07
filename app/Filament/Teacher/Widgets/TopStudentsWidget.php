<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopStudentsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->role('student')
                    ->join('experiences', 'users.id', '=', 'experiences.user_id')
                    ->select('users.*', 'experiences.experience_points', 'experiences.level_id')
                    ->orderBy('experiences.experience_points', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student')
                    ->searchable(),
                Tables\Columns\TextColumn::make('experience_points')
                    ->label('XP Points')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level_id')
                    ->label('Level')
                    ->sortable(),
                Tables\Columns\TextColumn::make('studentAnswers_count')
                    ->label('Completed Tasks')
                    ->counts('studentAnswers', fn (Builder $query) => $query->where('is_correct', true))
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
