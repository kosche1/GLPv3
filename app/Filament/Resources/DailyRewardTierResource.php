<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyRewardTierResource\Pages;
use App\Filament\Resources\DailyRewardTierResource\RelationManagers;
use App\Models\DailyRewardTier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DailyRewardTierResource extends Resource
{
    protected static ?string $model = DailyRewardTier::class;

    protected static ?string $navigationIcon = "heroicon-o-gift";
    protected static ?string $navigationGroup = "Rewards";
    protected static ?string $modelLabel = "Daily Reward Tier";
    protected static ?string $pluralModelLabel = "Daily Reward Tiers";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make("Basic Information")->schema([
                Forms\Components\TextInput::make("name")
                    ->required()
                    ->maxLength(255)
                    ->placeholder("E.g., Day 7 Premium Reward")
                    ->autocomplete(false)
                    ->columnSpanFull(),

                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make("day_number")
                            ->label("Day Number")
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->placeholder("E.g., 7")
                            ->helperText(
                                "The day in the streak when this reward becomes available"
                            ),

                        Forms\Components\TextInput::make("points_reward")
                            ->label("Points Reward")
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->placeholder("E.g., 100")
                            ->helperText("Base points awarded to the user"),
                    ]),
            ]),

            Forms\Components\Section::make("Reward Configuration")->schema([
                Forms\Components\Select::make("reward_type")
                    ->label("Reward Type")
                    ->options([
                        "points" => "Points Only",
                        "badge" => "Badge",
                        "item" => "Item",
                        "currency" => "Currency",
                        "multiplier" => "Points Multiplier",
                    ])
                    ->default("points")
                    ->required()
                    ->reactive(),

                Forms\Components\KeyValue::make("reward_data")
                    ->label("Reward Details")
                    ->columnSpanFull()
                    ->addButtonLabel("Add configuration item")
                    ->keyLabel("Parameter")
                    ->valueLabel("Value")
                    ->reorderable()
                    ->visible(
                        fn(Forms\Get $get) => $get("reward_type") !== "points"
                    )
                    ->helperText(function (Forms\Get $get) {
                        $type = $get("reward_type");

                        return match ($type) {
                            "badge"
                                => "For badges, specify badge_id and any other required parameters",
                            "item" => "For items, specify item_id and quantity",
                            "currency"
                                => "For currency, specify amount and currency_type",
                            "multiplier"
                                => "For multipliers, specify multiplier_value and duration_days",
                            default => "Additional reward configuration",
                        };
                    }),
            ]),

            Forms\Components\Section::make("Preview")
                ->schema([
                    Forms\Components\Placeholder::make("reward_preview")
                        ->label("Reward Preview")
                        ->content(function (Forms\Get $get) {
                            $type = $get("reward_type");
                            $points = $get("points_reward");

                            $preview = "Day {$get("day_number")}: {$get(
                                "name"
                            )}\n";
                            $preview .= "• {$points} base points\n";

                            if ($type !== "points") {
                                $preview .= "• Additional {$type} reward";
                            }

                            return $preview;
                        }),
                ])
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("day_number")
                    ->label("Day")
                    ->sortable(),
                Tables\Columns\TextColumn::make("name")
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make("points_reward")
                    ->label("Points")
                    ->sortable(),
                Tables\Columns\BadgeColumn::make("reward_type")
                    ->label("Type")
                    ->colors([
                        "primary" => "points",
                        "success" => "badge",
                        "warning" => "item",
                        "danger" => "currency",
                        "info" => "multiplier",
                    ]),
                Tables\Columns\TextColumn::make("userRewards.count")
                    ->label("Times Claimed")
                    ->counts("userRewards")
                    ->sortable(),
            ])
            ->defaultSort("day_number")
            ->filters([
                Tables\Filters\SelectFilter::make("reward_type")->options([
                    "points" => "Points Only",
                    "badge" => "Badge",
                    "item" => "Item",
                    "currency" => "Currency",
                    "multiplier" => "Points Multiplier",
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListDailyRewardTiers::route("/"),
            "create" => Pages\CreateDailyRewardTier::route("/create"),
            "edit" => Pages\EditDailyRewardTier::route("/{record}/edit"),
        ];
    }
}
