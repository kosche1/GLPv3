<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopStudents extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

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
                TextColumn::make('name')
                    ->label('Student')
                    ->searchable(),
                TextColumn::make('experience_points')
                    ->label('XP Points')
                    ->sortable(),
                TextColumn::make('level_id')
                    ->label('Level')
                    ->sortable(),
                TextColumn::make('studentAnswers_count')
                    ->label('Completed Tasks')
                    ->counts('studentAnswers', fn (Builder $query) => $query->where('is_correct', true))
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
