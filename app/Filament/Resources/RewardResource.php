<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RewardResource\Pages;
use App\Filament\Resources\RewardResource\RelationManagers;
use App\Models\Reward;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RewardResource extends Resource
{
    protected static ?string $model = Reward::class;

    protected static ?string $navigationIcon = "heroicon-o-gift";
    protected static ?string $navigationGroup = "Rewards";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description"),
                Forms\Components\Select::make("type")
                    ->required()
                    ->options([
                        "points" => "Experience Points",
                        "badge" => "Badge",
                        "item" => "Virtual Item",
                        "currency" => "Virtual Currency",
                        "discount" => "Discount",
                        "feature" => "Premium Feature",
                    ]),
                Forms\Components\KeyValue::make("reward_data")
                    ->required()
                    ->helperText("Configuration data for this reward"),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("type"),
                Tables\Columns\TextColumn::make("created_at")->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("type")->options([
                    "points" => "Experience Points",
                    "badge" => "Badge",
                    "item" => "Virtual Item",
                    "currency" => "Virtual Currency",
                    "discount" => "Discount",
                    "feature" => "Premium Feature",
                ]),
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
            "index" => Pages\ListRewards::route("/"),
            "create" => Pages\CreateReward::route("/create"),
            "edit" => Pages\EditReward::route("/{record}/edit"),
        ];
    }
}
