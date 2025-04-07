<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Challenge;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ChallengeCompletionWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Challenge::query()
                    ->where('is_active', true)
                    ->withCount(['users as total_participants'])
                    ->withCount(['users as completed_count' => function ($query) {
                        $query->where('user_challenges.status', 'completed');
                    }])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Challenge')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_participants')
                    ->label('Participants')
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_count')
                    ->label('Completed')
                    ->sortable(),
                Tables\Columns\TextColumn::make('completion_rate')
                    ->label('Completion Rate')
                    ->state(function (Challenge $record): string {
                        if ($record->total_participants === 0) {
                            return '0%';
                        }
                        
                        $percentage = ($record->completed_count / $record->total_participants) * 100;
                        return number_format($percentage, 1) . '%';
                    })
                    ->alignCenter(),
            ])
            ->paginated(false);
    }
}
