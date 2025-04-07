<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class StudentProgressTable extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Student Progress';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->role('student')
                    ->with('experience')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('experience.level_id')
                    ->label('Level')
                    ->sortable(),
                Tables\Columns\TextColumn::make('experience.experience_points')
                    ->label('XP Points')
                    ->sortable(),
                Tables\Columns\TextColumn::make('studentAnswers_count')
                    ->label('Completed Tasks')
                    ->counts('studentAnswers', fn (Builder $query) => $query->where('is_correct', true))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->date()
                    ->sortable(),
            ])
            ->paginated(true);
    }
}
