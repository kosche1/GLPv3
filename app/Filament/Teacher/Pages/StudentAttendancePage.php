<?php

namespace App\Filament\Teacher\Pages;

use App\Models\User;
use App\Services\AttendanceService;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

class StudentAttendancePage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?string $navigationLabel = 'Student Attendance';

    protected static ?string $title = 'Student Attendance';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.teacher.pages.student-attendance';

    protected function getAttendanceService(): AttendanceService
    {
        return App::make(AttendanceService::class);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->role('student'))
            ->columns([
                TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_logins')
                    ->label('Total Login Days')
                    ->getStateUsing(function (User $record): int {
                        return $this->getAttendanceService()->getTotalLogins($record->id);
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('id', $direction);
                    }),

                TextColumn::make('current_streak')
                    ->label('Current Streak')
                    ->getStateUsing(function (User $record): int {
                        return $this->getAttendanceService()->getCurrentStreak($record->id);
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('id', $direction);
                    }),

                TextColumn::make('attendance_percentage')
                    ->label('Attendance %')
                    ->getStateUsing(function (User $record): string {
                        $percentage = $this->getAttendanceService()->getAttendancePercentage($record->id);
                        return number_format($percentage, 1) . '%';
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('id', $direction);
                    }),

                TextColumn::make('last_login')
                    ->label('Last Login')
                    ->getStateUsing(function (User $record): string {
                        $lastLoginDate = $this->getAttendanceService()->getLastLogin($record->id);
                        return $lastLoginDate ? date('M d, Y', strtotime($lastLoginDate)) : 'Never';
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('id', $direction);
                    }),

                TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function (User $record): string {
                        return '<a href="' . route('attendance.student-detail', $record->id) . '" class="text-primary-600 hover:text-primary-900">View Details</a>';
                    }),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                // Add actions if needed
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ]);
    }
}
