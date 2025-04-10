<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;
use App\Filament\Resources\CustomUserResource\Pages;

class CustomUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'User Management';
    
    protected static ?string $slug = 'user-management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('User Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn ($state) => filled($state))
                        ->label(fn (string $operation): string => $operation === 'create' ? 'Password' : 'New Password')
                        ->maxLength(255),
                ])
                ->columns(2),
                
            Forms\Components\Section::make('Role Assignment')
                ->schema([
                    Forms\Components\Select::make('roles')
                        ->label('Assign Role')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->helperText('Assign at least one role to the user.'),
                ])
                ->description('Users must have a role to access specific features of the application.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->label('Roles'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->multiple()
                    ->label('Filter by Role')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit User'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('assignRole')
                        ->label('Assign Role')
                        ->icon('heroicon-o-user-group')
                        ->form([
                            Forms\Components\Select::make('role')
                                ->label('Select Role')
                                ->options(function () {
                                    return Role::pluck('name', 'id');
                                })
                                ->required()
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data) {
                            $role = Role::findById($data['role']);

                            foreach ($records as $record) {
                                $record->assignRole($role);
                            }
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotification(
                            fn () => Notification::make()
                                ->success()
                                ->title('Role assigned')
                                ->body('The selected role has been assigned to the selected users.')
                        ),
                ]),
            ]);
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
            'index' => Pages\ListCustomUsers::route('/'),
            'create' => Pages\CreateCustomUser::route('/create'),
            'edit' => Pages\EditCustomUser::route('/{record}/edit'),
        ];
    }
}
