<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = "heroicon-s-pencil";
    protected static ?string $navigationGroup = "Gamification";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description"),
                Forms\Components\TextInput::make("points_per_action")
                    ->numeric()
                    ->minValue(1)
                    ->default(10)
                    ->helperText(
                        "Points awarded each time this activity is performed"
                    ),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("description")->limit(50),
                Tables\Columns\TextColumn::make(
                    "points_per_action"
                )->sortable(),
                Tables\Columns\TextColumn::make("created_at")->dateTime(),
            ])
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
            "index" => Pages\ListActivities::route("/"),
            "create" => Pages\CreateActivity::route("/create"),
            "edit" => Pages\EditActivity::route("/{record}/edit"),
        ];
    }
}
