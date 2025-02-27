<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Filament\Resources\AchievementResource\RelationManagers;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LevelUp\Experience\Models\Achievement as LevelUpAchievement;

class AchievementResource extends Resource
{
    protected static ?string $model = LevelUpAchievement::class;
    protected static ?string $navigationIcon = "heroicon-o-check";
    protected static ?string $navigationGroup = "Gamification";
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description")->required(),
                Forms\Components\FileUpload::make("image")
                    ->image()
                    ->directory("achievements"),
                Forms\Components\Toggle::make("is_secret")
                    ->label("Secret Achievement")
                    ->default(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("description")->limit(50),
                Tables\Columns\ImageColumn::make("image"),
                Tables\Columns\BooleanColumn::make("is_secret")->label(
                    "Secret"
                ),
                Tables\Columns\TextColumn::make("created_at")->dateTime(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make("is_secret")->label(
                    "Secret Achievements"
                ),
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
            "index" => Pages\ListAchievements::route("/"),
            "create" => Pages\CreateAchievement::route("/create"),
            "edit" => Pages\EditAchievement::route("/{record}/edit"),
        ];
    }
}
