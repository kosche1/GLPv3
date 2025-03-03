<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferralProgramResource\Pages;
use App\Filament\Resources\ReferralProgramResource\RelationManagers;
use App\Models\ReferralProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReferralProgramResource extends Resource
{
    protected static ?string $model = ReferralProgram::class;

    protected static ?string $navigationIcon = "heroicon-o-users";
    protected static ?string $navigationGroup = "Rewards";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description"),
                Forms\Components\TextInput::make("referrer_points")
                    ->required()
                    ->numeric()
                    ->label("Points for Referrer")
                    ->minValue(0),
                Forms\Components\TextInput::make("referee_points")
                    ->required()
                    ->numeric()
                    ->label("Points for New User")
                    ->minValue(0),
                Forms\Components\Toggle::make("is_active")
                    ->label("Active")
                    ->default(true),
                Forms\Components\KeyValue::make(
                    "additional_rewards"
                )->helperText("Additional rewards beyond points"),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("referrer_points")->label(
                    "Referrer Points"
                ),
                Tables\Columns\TextColumn::make("referee_points")->label(
                    "New User Points"
                ),
                Tables\Columns\BooleanColumn::make("is_active")->label(
                    "Active"
                ),
                Tables\Columns\TextColumn::make("created_at")->dateTime(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make("is_active")->label(
                    "Active Programs"
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
            "index" => Pages\ListReferralPrograms::route("/"),
            "create" => Pages\CreateReferralProgram::route("/create"),
            "edit" => Pages\EditReferralProgram::route("/{record}/edit"),
        ];
    }
}
