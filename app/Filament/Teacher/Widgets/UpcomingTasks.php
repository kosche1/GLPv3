<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Task;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingTasks extends BaseWidget
{
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->whereDate('due_date', '>=', now())
                    ->orderBy('due_date')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Task')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('challenge.title')
                    ->label('Challenge')
                    ->searchable(),
            ])
            ->paginated(false);
    }
}