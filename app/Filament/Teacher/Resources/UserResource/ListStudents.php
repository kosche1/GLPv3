<?php

namespace App\Filament\Teacher\Resources\UserResource;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Contracts\TranslatableContentDriver;

class ListStudents extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;

    // Add missing property
    protected bool $isCachingForms = false;

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->role('student')
                    ->with('experience')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Student')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('experience.level_id')
                    ->label('Level')
                    ->sortable(),
                TextColumn::make('experience.experience_points')
                    ->label('XP Points')
                    ->sortable(),
                TextColumn::make('studentAnswers_count')
                    ->label('Completed Tasks')
                    ->counts('studentAnswers', fn (Builder $query) => $query->where('is_correct', true))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Action::make('view_progress')
                    ->label('View Progress')
                    ->icon('heroicon-o-academic-cap')
                    ->url(fn (User $record) => '/admin/user-management/' . $record->id . '/edit')
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ]);
    }

    public function render()
    {
        return view('livewire.filament.teacher.resources.user-resource.list-students');
    }
}
