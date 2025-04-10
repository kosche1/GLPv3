<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopStudentsTable extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Top Performing Students';

    protected function getTableSearchDebounce(): ?int
    {
        return 500;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->role('student')
                    ->join('experiences', 'users.id', '=', 'experiences.user_id')
                    ->select('users.*', 'experiences.experience_points', 'experiences.level_id')
                    ->orderBy('experiences.experience_points', 'desc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('level_id')
                    ->label('Level')
                    ->sortable(),

                Tables\Columns\TextColumn::make('experience_points')
                    ->label('XP Points')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('studentAnswers_count')
                    ->label('Completed Tasks')
                    ->counts('studentAnswers', fn (Builder $query) => $query->where('is_correct', true))
                    ->sortable(),
            ])
            ->paginated(false)
            ->searchable()
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->searchPlaceholder('Search students...')
            ->persistSearchInSession()
            ->deferLoading();
    }
}
