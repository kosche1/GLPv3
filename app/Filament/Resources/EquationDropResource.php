<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquationDropResource\Pages;
use App\Filament\Resources\EquationDropResource\RelationManagers;
use App\Models\EquationDrop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EquationDropResource extends Resource
{
    protected static ?string $model = EquationDrop::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'Equation Drop';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Game Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->maxLength(1000),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
                Forms\Components\Section::make('Timer Settings')
                    ->schema([
                        Forms\Components\TextInput::make('easy_timer_seconds')
                            ->label('Easy Difficulty Timer (seconds)')
                            ->required()
                            ->numeric()
                            ->minValue(10)
                            ->default(60),
                        Forms\Components\TextInput::make('medium_timer_seconds')
                            ->label('Medium Difficulty Timer (seconds)')
                            ->required()
                            ->numeric()
                            ->minValue(10)
                            ->default(45),
                        Forms\Components\TextInput::make('hard_timer_seconds')
                            ->label('Hard Difficulty Timer (seconds)')
                            ->required()
                            ->numeric()
                            ->minValue(10)
                            ->default(30),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquationDrops::route('/'),
            'create' => Pages\CreateEquationDrop::route('/create'),
            'edit' => Pages\EditEquationDrop::route('/{record}/edit'),
        ];
    }
}
