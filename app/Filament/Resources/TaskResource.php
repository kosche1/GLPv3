<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = "heroicon-o-clipboard";
    protected static ?string $navigationGroup = "Rewards";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description"),
                Forms\Components\TextInput::make("points_reward")
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\Select::make("type")
                    ->options([
                        "daily" => "Daily",
                        "weekly" => "Weekly",
                        "onetime" => "One-time",
                        "repeatable" => "Repeatable",
                        "challenge" => "Challenge",
                    ])
                    ->required(),
                Forms\Components\Toggle::make("is_active")
                    ->label("Active")
                    ->default(true),
                Forms\Components\KeyValue::make("completion_criteria")
                    ->valueLabel("Requirement")
                    ->keyLabel("Criteria")
                    ->required()
                    ->helperText(
                        "Define the criteria for completing this task"
                    ),
                Forms\Components\Textarea::make("answer_key")
                    ->helperText("The correct answers for this task")
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make("points_reward"),
                Tables\Columns\TextColumn::make("type"),
                Tables\Columns\BooleanColumn::make("is_active")->label(
                    "Active"
                ),
                Tables\Columns\TextColumn::make("created_at")->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("type")->options([
                    "daily" => "Daily",
                    "weekly" => "Weekly",
                    "onetime" => "One-time",
                    "repeatable" => "Repeatable",
                    "challenge" => "Challenge",
                ]),
                Tables\Filters\TernaryFilter::make("is_active")->label(
                    "Active Tasks"
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('attachToChallenge')
                    ->label('Attach to Challenge')
                    ->icon('heroicon-s-link')
                    ->hidden(fn (Task $record) => $record->challenge_id !== null)
                    ->form([
                        Forms\Components\Select::make('challenge_id')
                            ->label('Select Challenge')
                            ->options(fn () => \App\Models\Challenge::where('is_active', true)
                                ->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                    ])
                    ->action(function (Task $record, array $data): void {
                        $record->update(['challenge_id' => $data['challenge_id']]);
                        Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Task attached to challenge successfully')
                            ->send();
                    })
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
            "index" => Pages\ListTasks::route("/"),
            "create" => Pages\CreateTask::route("/create"),
            "edit" => Pages\EditTask::route("/{record}/edit"),
        ];
    }
}
