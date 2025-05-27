<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackupArchiveResource\Pages;
use App\Models\BackupArchive;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class BackupArchiveResource extends Resource
{
    protected static ?string $model = BackupArchive::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-x-mark';

    protected static ?string $navigationLabel = 'Database Archives';

    protected static ?string $modelLabel = 'Archived Backup';

    protected static ?string $pluralModelLabel = 'Archived Backups';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Archive Information')
                    ->schema([
                        Forms\Components\TextInput::make('filename')
                            ->label('Filename')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('original_path')
                            ->label('Original Path')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('disk')
                            ->label('Storage Disk')
                            ->options([
                                'local' => 'Local',
                                's3' => 'S3',
                                'public' => 'Public',
                            ])
                            ->required(),
                        
                        Forms\Components\TextInput::make('size')
                            ->label('File Size')
                            ->required()
                            ->maxLength(50),
                    ])->columns(2),

                Forms\Components\Section::make('Dates')
                    ->schema([
                        Forms\Components\DateTimePicker::make('backup_date')
                            ->label('Backup Created Date')
                            ->required()
                            ->timezone('Asia/Manila'),
                        
                        Forms\Components\DateTimePicker::make('archived_date')
                            ->label('Archived Date')
                            ->required()
                            ->timezone('Asia/Manila'),
                    ])->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Select::make('archived_by')
                            ->label('Archived By')
                            ->relationship('archivedBy', 'name')
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->maxLength(1000),
                        
                        Forms\Components\KeyValue::make('metadata')
                            ->label('Metadata')
                            ->keyLabel('Property')
                            ->valueLabel('Value'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filename')
                    ->label('Filename')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->tooltip('Click to copy'),

                Tables\Columns\TextColumn::make('backup_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Database Only' => 'info',
                        'Files Only' => 'warning',
                        'Full Backup' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('disk')
                    ->label('Storage')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->sortable(),

                Tables\Columns\TextColumn::make('backup_date')
                    ->label('Created')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->timezone('Asia/Manila'),

                Tables\Columns\TextColumn::make('archived_date')
                    ->label('Archived')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->timezone('Asia/Manila'),

                Tables\Columns\TextColumn::make('archivedBy.name')
                    ->label('Archived By')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('disk')
                    ->label('Storage Disk')
                    ->options([
                        'local' => 'Local',
                        's3' => 'S3',
                        'public' => 'Public',
                    ]),

                Tables\Filters\Filter::make('backup_date')
                    ->form([
                        Forms\Components\DatePicker::make('backup_from')
                            ->label('Backup Created From'),
                        Forms\Components\DatePicker::make('backup_until')
                            ->label('Backup Created Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['backup_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('backup_date', '>=', $date),
                            )
                            ->when(
                                $data['backup_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('backup_date', '<=', $date),
                            );
                    }),

                Tables\Filters\Filter::make('archived_date')
                    ->form([
                        Forms\Components\DatePicker::make('archived_from')
                            ->label('Archived From'),
                        Forms\Components\DatePicker::make('archived_until')
                            ->label('Archived Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['archived_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('archived_date', '>=', $date),
                            )
                            ->when(
                                $data['archived_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('archived_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Archive Record')
                    ->modalDescription('Are you sure you want to permanently delete this archive record? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Archive record deleted')
                            ->body('The archive record has been permanently deleted.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Archive Records')
                        ->modalDescription('Are you sure you want to permanently delete the selected archive records? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete selected')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Archive records deleted')
                                ->body('The selected archive records have been permanently deleted.')
                        ),
                ]),
            ])
            ->defaultSort('archived_date', 'desc')
            ->emptyStateHeading('No archived backups')
            ->emptyStateDescription('Deleted backup information will appear here.')
            ->emptyStateIcon('heroicon-o-archive-box-x-mark');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBackupArchives::route('/'),
            'create' => Pages\CreateBackupArchive::route('/create'),
            'view' => Pages\ViewBackupArchive::route('/{record}'),
            'edit' => Pages\EditBackupArchive::route('/{record}/edit'),
        ];
    }
}
