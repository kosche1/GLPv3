<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Filament\Resources\LevelResource\RelationManagers;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LevelUp\Experience\Models\Level as LevelUpLevel;

class LevelResource extends Resource
{
    protected static ?string $model = LevelUpLevel::class;

    protected static ?string $navigationIcon = "heroicon-o-chart-bar";
    protected static ?string $navigationGroup = "Gamification";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("level")
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make("next_level_experience")
                    ->label("XP Needed for Next Level")
                    ->numeric()
                    ->helperText("Leave empty for final level"),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("level")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("next_level_experience")
                    ->label("XP for Next Level")
                    ->sortable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort("level", "asc")
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
            "index" => Pages\ListLevels::route("/"),
            "create" => Pages\CreateLevel::route("/create"),
            "edit" => Pages\EditLevel::route("/{record}/edit"),
        ];
    }
}
