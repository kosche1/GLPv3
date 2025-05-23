<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\ActivityLogResource\Pages;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 99;

    public static function getNavigationLabel(): string
    {
        return 'Audit Trail';
    }

    public static function getPluralLabel(): string
    {
        return 'Audit Trail';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('log_name')
                    ->label('Subject')
                    ->required(),
                Forms\Components\TextInput::make('causer_type')
                    ->label('User Type')
                    ->disabled(),
                Forms\Components\TextInput::make('causer_id')
                    ->label('User ID')
                    ->disabled(),
                Forms\Components\TextInput::make('description')
                    ->label('Description')
                    ->required(),
                Forms\Components\TextInput::make('event')
                    ->label('Action')
                    ->required(),
                Forms\Components\TextInput::make('subject_type')
                    ->label('Resource Type')
                    ->disabled(),
                Forms\Components\TextInput::make('subject_id')
                    ->label('Resource ID')
                    ->disabled(),
                Forms\Components\KeyValue::make('properties')
                    ->label('Properties'),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Created At')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('log_name')
                    ->label('Subject')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('causer.name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state, $record) => $state ?? ($record->causer_type ? class_basename($record->causer_type) . ' #' . $record->causer_id : 'System')),
                TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('event')
                    ->label('Action')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state): string => $state ? ucfirst($state) : 'Unknown')
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        null => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('subject_type')
                    ->label('Resource Type')
                    ->formatStateUsing(fn (?string $state): string => $state ? class_basename($state) : '-')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Subject')
                    ->options(function () {
                        return Activity::distinct('log_name')->pluck('log_name', 'log_name')->toArray();
                    }),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View')
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
            'edit' => Pages\EditActivityLog::route('/{record}/edit'),
        ];
    }
}
