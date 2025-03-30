<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Activity;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivities extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Activity')
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}