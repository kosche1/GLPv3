<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BadgeResource\Pages;
use App\Filament\Resources\BadgeResource\RelationManagers;
use App\Models\Badge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BadgeResource extends Resource
{
    protected static ?string $model = Badge::class;
    protected static ?string $navigationIcon = "heroicon-o-shield-check";
    protected static ?string $navigationGroup = "Gamification";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description")->required(),
                Forms\Components\FileUpload::make("image")
                    ->image()
                    ->directory("badges"),
                Forms\Components\Select::make("trigger_type")
                    ->required()
                    ->options([
                        "achievement" => "Achievement",
                        "level" => "Level",
                        "points" => "Points",
                        "task" => "Task",
                        "referral" => "Referral",
                    ]),
                Forms\Components\KeyValue::make(
                    "trigger_conditions"
                )->required(),
                Forms\Components\Select::make("rarity_level")
                    ->required()
                    ->options([
                        1 => "Common",
                        2 => "Uncommon",
                        3 => "Rare",
                        4 => "Epic",
                        5 => "Legendary",
                    ])
                    ->default(1),
                Forms\Components\Toggle::make("is_hidden")
                    ->label("Hidden Badge")
                    ->default(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("trigger_type"),
                Tables\Columns\TextColumn::make("rarity_level"),
                Tables\Columns\ImageColumn::make("image"),
                Tables\Columns\BooleanColumn::make("is_hidden")->label(
                    "Hidden"
                ),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("trigger_type")->options([
                    "achievement" => "Achievement",
                    "level" => "Level",
                    "points" => "Points",
                    "task" => "Task",
                    "referral" => "Referral",
                ]),
                Tables\Filters\SelectFilter::make("rarity_level")->options([
                    1 => "Common",
                    2 => "Uncommon",
                    3 => "Rare",
                    4 => "Epic",
                    5 => "Legendary",
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
            "index" => Pages\ListBadges::route("/"),
            "create" => Pages\CreateBadge::route("/create"),
            "edit" => Pages\EditBadge::route("/{record}/edit"),
        ];
    }
}
