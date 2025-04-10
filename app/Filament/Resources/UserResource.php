<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('User Information')
                ->schema([
                    Forms\Components\TextInput::make("name")
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make("email")
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make("email_verified_at"),
                    Forms\Components\TextInput::make("password")
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
                    Forms\Components\Select::make("roles")
                        ->relationship("roles", "name")
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required()
                        ->default(3) // Default to student role (ID 3)
                        ->helperText('Assign at least one role to the user. New users should typically be assigned the "student" role.'),
                ])
                ->description('Users must have a role to access specific features of the application.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("email")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'faculty' => 'warning',
                        'student' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make("email_verified_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("updated_at")
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
                                    return \Spatie\Permission\Models\Role::pluck('name', 'id');
                                })
                                ->required()
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data) {
                            $role = \Spatie\Permission\Models\Role::findById($data['role']);

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
            "index" => Pages\ListUsers::route("/"),
            "create" => Pages\CreateUser::route("/create"),
            "edit" => Pages\EditUser::route("/{record}/edit"),
        ];
    }
}
