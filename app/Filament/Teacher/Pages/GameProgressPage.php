<?php

namespace App\Filament\Teacher\Pages;

use App\Models\User;
use App\Exports\GameProgressExport;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action as PageAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Model;

class GameProgressPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.teacher.pages.game-progress-page';
    protected static ?string $title = 'Game Progress Overview';
    protected static ?string $navigationLabel = 'Game Progress';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?int $navigationSort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->getStateUsing(function (Model $record): string {
                        return $record->getRoleNames()->first() ?? 'student';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'teacher' => 'warning',
                        'student' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('typing_attempts')
                    ->label('Typing Speed')
                    ->alignCenter()
                    ->getStateUsing(function (Model $record): string {
                        $count = $record->typing_test_results()->count();
                        return $count > 0 ? $count : 0;
                    })
                    ->color(fn (Model $record): string =>
                        $record->typing_test_results()->count() > 0 ? 'primary' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('equation_attempts')
                    ->label('Equation Drop')
                    ->alignCenter()
                    ->getStateUsing(function (Model $record): string {
                        $count = $record->equation_drop_results()->count();
                        return $count > 0 ? $count : 0;
                    })
                    ->color(fn (Model $record): string =>
                        $record->equation_drop_results()->count() > 0 ? 'success' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('maze_attempts')
                    ->label('Historical Maze')
                    ->alignCenter()
                    ->getStateUsing(function (Model $record): string {
                        $count = $record->historical_timeline_maze_results()->count();
                        return $count > 0 ? $count : 0;
                    })
                    ->color(fn (Model $record): string =>
                        $record->historical_timeline_maze_results()->count() > 0 ? 'warning' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('invest_attempts')
                    ->label('InvestSmart')
                    ->alignCenter()
                    ->getStateUsing(function (Model $record): string {
                        $count = $record->invest_smart_results()->count();
                        return $count > 0 ? $count : 0;
                    })
                    ->color(fn (Model $record): string =>
                        $record->invest_smart_results()->count() > 0 ? 'danger' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('recipe_attempts')
                    ->label('Recipe Builder')
                    ->alignCenter()
                    ->getStateUsing(function (Model $record): string {
                        $count = $record->user_recipes()->count();
                        return $count > 0 ? $count : 0;
                    })
                    ->color(fn (Model $record): string =>
                        $record->user_recipes()->count() > 0 ? 'info' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'student' => 'Student',
                        'teacher' => 'Teacher',
                        'admin' => 'Admin',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $role): Builder => $query->role($role),
                        );
                    }),

                Filter::make('has_game_activity')
                    ->label('Has Game Activity')
                    ->query(fn (Builder $query): Builder => $query->where(function ($query) {
                        $query->whereHas('typing_test_results')
                            ->orWhereHas('equation_drop_results')
                            ->orWhereHas('historical_timeline_maze_results')
                            ->orWhereHas('invest_smart_results')
                            ->orWhereHas('user_recipes');
                    })),

                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')
                            ->label('From Date'),
                        DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->where('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->where('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_progress')
                    ->label('View Progress')
                    ->icon('heroicon-o-chart-bar')
                    ->color('info')
                    ->modalHeading(fn (User $record): string => "Game Progress - {$record->name}")
                    ->modalContent(function (User $record) {
                        $typingResults = $record->typing_test_results()->latest()->get();
                        $equationResults = $record->equation_drop_results()->latest()->get();
                        $mazeResults = $record->historical_timeline_maze_results()->latest()->get();
                        $investResults = $record->invest_smart_results()->latest()->get();
                        $recipeResults = $record->user_recipes()->with('recipeTemplate')->latest()->get();

                        return view('filament.modals.student-progress', [
                            'user' => $record,
                            'typingResults' => $typingResults,
                            'equationResults' => $equationResults,
                            'mazeResults' => $mazeResults,
                            'investResults' => $investResults,
                            'recipeResults' => $recipeResults,
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('7xl'),
            ])
            ->bulkActions([
                // Teachers don't have user management access
            ])
            ->defaultSort('name')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->with([
                'typing_test_results',
                'equation_drop_results',
                'historical_timeline_maze_results',
                'invest_smart_results',
                'user_recipes',
                'roles'
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            PageAction::make('export_csv')
                ->label('Export as CSV')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    $export = new GameProgressExport();
                    return $export->exportCsv();
                }),

            PageAction::make('export_excel')
                ->label('Export as Excel')
                ->icon('heroicon-o-table-cells')
                ->color('info')
                ->action(function () {
                    $export = new GameProgressExport();
                    return $export->exportExcel();
                }),

            PageAction::make('export_pdf')
                ->label('Export as PDF')
                ->icon('heroicon-o-document-text')
                ->color('warning')
                ->action(function () {
                    $export = new GameProgressExport();
                    return $export->exportPdf();
                }),
        ];
    }
}
