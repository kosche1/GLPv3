<?php

namespace App\Filament\Teacher\Resources\ChallengeResource;

use App\Models\Challenge;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Actions\Action;
use Livewire\Component;

use Filament\Support\Contracts\TranslatableContentDriver;

class ListChallenges extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Challenge::query()
                    ->latest()
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Challenge')
                    ->searchable(),
                TextColumn::make('difficulty_level')
                    ->label('Difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'primary',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        'expert' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('points_reward')
                    ->label('Points')
                    ->numeric(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('tasks_count')
                    ->label('Tasks')
                    ->counts('tasks'),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Challenge $record) => route('filament.admin.resources.challenges.edit', $record)),

                Action::make('view_tasks')
                    ->label('View Tasks')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->url(fn (Challenge $record) => route('filament.admin.resources.challenges.edit', $record) . '#relation-manager-challenges-tasks-relation-manager'),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ]);
    }

    public function render()
    {
        return view('livewire.filament.teacher.resources.challenge-resource.list-challenges');
    }
}
