<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaderboardCategoryResource\Pages;
use App\Filament\Resources\LeaderboardCategoryResource\RelationManagers;
use App\Models\LeaderboardCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaderboardCategoryResource extends Resource
{
    protected static ?string $model = LeaderboardCategory::class;

    protected static ?string $navigationIcon = "heroicon-o-trophy";
    protected static ?string $navigationGroup = "Gamification";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description"),
                Forms\Components\Select::make("metric")
                    ->required()
                    ->options([
                        "points" => "Experience Points",
                        "achievements" => "Achievements Completed",
                        "streak" => "Streak Days",
                        "badges" => "Badges Earned",
                        "tasks" => "Tasks Completed",
                        "referrals" => "Referrals Made",
                    ]),
                Forms\Components\Select::make("timeframe")
                    ->required()
                    ->options([
                        "daily" => "Daily",
                        "weekly" => "Weekly",
                        "monthly" => "Monthly",
                        "alltime" => "All Time",
                    ])
                    ->default("alltime"),
                Forms\Components\Toggle::make("is_active")
                    ->label("Active")
                    ->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("metric"),
                Tables\Columns\TextColumn::make("timeframe"),
                Tables\Columns\BooleanColumn::make("is_active")->label(
                    "Active"
                ),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Updated At'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("metric")->options([
                    "points" => "Experience Points",
                    "achievements" => "Achievements",
                    "streak" => "Streak Days",
                    "badges" => "Badges",
                    "tasks" => "Tasks",
                    "referrals" => "Referrals",
                ]),
                Tables\Filters\SelectFilter::make("timeframe")->options([
                    "daily" => "Daily",
                    "weekly" => "Weekly",
                    "monthly" => "Monthly",
                    "alltime" => "All Time",
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
            "index" => Pages\ListLeaderboardCategories::route("/"),
            "create" => Pages\CreateLeaderboardCategory::route("/create"),
            "edit" => Pages\EditLeaderboardCategory::route("/{record}/edit"),
        ];
    }
}
