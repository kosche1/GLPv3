<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Reports extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Reports';
    protected static ?string $title = 'Student Reports';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Analytics';

    protected static string $view = 'filament.pages.reports';

    public $activeTab = 'daily';

    public function getTableQuery(): Builder
    {
        $query = User::query()
            ->role('student')
            ->join('experiences', 'users.id', '=', 'experiences.user_id')
            ->join('levels', 'experiences.level_id', '=', 'levels.id')
            ->select('users.*', 'experiences.experience_points', 'levels.level as level_number')
            ->orderBy('experiences.experience_points', 'desc');

        // Apply date filters based on the active tab
        if ($this->activeTab === 'daily') {
            // Filter for today only
            $query->whereDate('users.updated_at', now()->toDateString());
        } elseif ($this->activeTab === 'weekly') {
            // Filter for the current week (last 7 days)
            $query->whereDate('users.updated_at', '>=', now()->subDays(7));
        } elseif ($this->activeTab === 'monthly') {
            // Filter for the current month
            $query->whereMonth('users.updated_at', now()->month)
                  ->whereYear('users.updated_at', now()->year);
        }

        return $query;
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function getActiveTabLabel(): string
    {
        return match($this->activeTab) {
            'daily' => 'Daily Report (' . now()->format('F d, Y') . ')',
            'weekly' => 'Weekly Report (Last 7 Days)',
            'monthly' => 'Monthly Report (' . now()->format('F Y') . ')',
            default => 'Student Report',
        };
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->heading($this->getActiveTabLabel())
            ->columns([
                TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level_number')
                    ->label('Level')
                    ->sortable(),
                TextColumn::make('experience_points')
                    ->label('XP Points')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Join Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Activity')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('date_filter')
                    ->form([
                        DatePicker::make('date')
                            ->label('Specific Date')
                            ->placeholder('Filter by specific date'),
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->placeholder('Filter from date'),
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->placeholder('Filter to date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('users.updated_at', '=', $date)
                            )
                            ->when(
                                $data['start_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('users.updated_at', '>=', $date)
                            )
                            ->when(
                                $data['end_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('users.updated_at', '<=', $date)
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['date'] ?? null) {
                            $indicators[] = Indicator::make('Activity on: ' . Carbon::parse($data['date'])->format('M d, Y'));
                        }

                        if ($data['start_date'] ?? null) {
                            $indicators[] = Indicator::make('Activity from: ' . Carbon::parse($data['start_date'])->format('M d, Y'));
                        }

                        if ($data['end_date'] ?? null) {
                            $indicators[] = Indicator::make('Activity until: ' . Carbon::parse($data['end_date'])->format('M d, Y'));
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Action::make('export')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        // This would be implemented with a proper CSV export
                        // For now, we'll just show a notification
                        return redirect()->back()->with('success', 'Export functionality will be implemented soon!');
                    }),
            ])
            ->bulkActions([
                BulkAction::make('export')
                    ->label('Export Selected')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function (Collection $records) {
                        // This would be implemented with a proper CSV export
                        // For now, we'll just show a notification
                        return redirect()->back()->with('success', 'Selected ' . $records->count() . ' records for export!');
                    })
            ])
            ->paginated([10, 25, 50, 100]);
    }
}
