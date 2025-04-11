<?php

namespace App\Filament\Components;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use ShuvroRoy\FilamentSpatieLaravelBackup\Models\BackupDestination;
use ShuvroRoy\FilamentSpatieLaravelBackup\Components\BackupDestinationListRecords;
use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\BackupDestination\BackupDestination as SpatieBackupDestination;

class CustomBackupDestinationListRecords extends BackupDestinationListRecords
{
    public function table(Table $table): Table
    {
        return $table
            ->query(BackupDestination::query())
            ->columns([
                Tables\Columns\TextColumn::make('path')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.fields.path'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('disk')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.fields.disk'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.fields.date'))
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.fields.size'))
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('disk')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.filters.disk'))
                    ->options(\ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackup::getFilterDisks()),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.actions.download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (BackupDestination $record) {
                        return response()->download(Storage::disk($record->disk)->path($record->path));
                    }),

                Tables\Actions\Action::make('restore')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.actions.restore'))
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-arrow-path')
                    ->modalHeading('Restore Backup')
                    ->modalDescription('Are you sure you want to restore this backup? This will replace your current data.')
                    ->modalSubmitActionLabel('Yes, restore')
                    ->action(function (BackupDestination $record) {
                        // Call the restore command
                        $exitCode = Artisan::call('backup:restore', [
                            'path' => $record->path,
                            'disk' => $record->disk,
                        ]);

                        if ($exitCode === 0) {
                            Notification::make()
                                ->title(__('filament-spatie-backup::backup.pages.backups.messages.backup_restore_success'))
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Failed to restore backup')
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('delete')
                    ->label(__('filament-spatie-backup::backup.components.backup_destination_list.table.actions.delete'))
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->modalIcon('heroicon-o-trash')
                    ->action(function (BackupDestination $record) {
                        SpatieBackupDestination::create($record->disk, config('backup.backup.name'))
                            ->backups()
                            ->first(function (Backup $backup) use ($record) {
                                return $backup->path() === $record->path;
                            })
                            ->delete();

                        Notification::make()
                            ->title(__('filament-spatie-backup::backup.pages.backups.messages.backup_delete_success'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                // You can add bulk actions here if needed
            ]);
    }
}
