<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChallengeResource\Pages;
use App\Filament\Resources\ChallengeResource\RelationManagers;
use App\Models\Challenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LevelUp\Experience\Models\Level;

class ChallengeResource extends Resource
{
    protected static ?string $model = Challenge::class;

    protected static ?string $navigationIcon = "heroicon-o-fire";
    protected static ?string $navigationGroup = "Gamification";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make("Basic Information")->schema([
                Forms\Components\TextInput::make("name")
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make("description")
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make(
                            "start_date"
                        )->required(),
                        Forms\Components\DateTimePicker::make("end_date")
                            ->after("start_date")
                            ->helperText("Leave empty for ongoing challenges"),
                    ]),
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make("points_reward")
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(10),
                        Forms\Components\TextInput::make("max_participants")
                            ->numeric()
                            ->minValue(1)
                            ->placeholder("Unlimited if empty"),
                    ]),
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make("difficulty_level")
                            ->required()
                            ->options([
                                "easy" => "Easy",
                                "medium" => "Medium",
                                "hard" => "Hard",
                                "expert" => "Expert",
                            ])
                            ->default("medium"),
                        Forms\Components\Select::make("required_level")
                            ->required()
                            ->options(function () {
                                $levels = Level::all()
                                    ->pluck("level", "level")
                                    ->toArray();
                                return $levels;
                            })
                            ->default(1)
                            ->helperText(
                                "Minimum user level required to participate"
                            ),
                    ]),
                Forms\Components\Toggle::make("is_active")
                    ->label("Active")
                    ->default(true)
                    ->helperText(
                        "Inactive challenges are not visible to users"
                    ),
            ]),
            Forms\Components\Section::make("Completion Requirements")->schema([
                Forms\Components\KeyValue::make("completion_criteria")
                    ->keyLabel("Criteria")
                    ->valueLabel("Value")
                    ->required()
                    ->default([
                        "complete_tasks" => "1",
                        "streak_days" => "0",
                    ])
                    ->helperText(
                        "Define what users need to do to complete this challenge"
                    ),
            ]),
            Forms\Components\Section::make("Rewards")->schema([
                Forms\Components\KeyValue::make("additional_rewards")
                    ->keyLabel("Reward Type")
                    ->valueLabel("Value")
                    ->helperText("Additional rewards beyond points"),
                Forms\Components\CheckboxList::make("badges")
                    ->relationship("badges", "name")
                    ->helperText(
                        "Badges awarded for completing this challenge"
                    ),
                Forms\Components\CheckboxList::make("achievements")
                    ->relationship("achievements", "name")
                    ->helperText(
                        "Achievements granted for completing this challenge"
                    ),
            ]),
            Forms\Components\Section::make("Required Activities")->schema([
                Forms\Components\Repeater::make("activities")
                    ->relationship("activities")
                    ->schema([
                        Forms\Components\Select::make("activity_id")
                            ->label("Activity")
                            ->relationship("activity", "name")
                            ->required(),
                        Forms\Components\TextInput::make("required_count")
                            ->label("Required Count")
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required()
                            ->helperText(
                                "How many times user must perform this activity"
                            ),
                    ])
                    ->itemLabel(
                        fn(array $state): ?string => $state["activity_id"]
                            ? "Activity #{$state["activity_id"]} (x{$state["required_count"]})"
                            : null
                    )
                    ->addActionLabel("Add Activity")
                    ->collapsible(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\BadgeColumn::make("difficulty_level")->colors([
                    "success" => "easy",
                    "warning" => "medium",
                    "danger" => "hard",
                    "gray" => "expert",
                ]),
                Tables\Columns\TextColumn::make("points_reward")->sortable(),
                Tables\Columns\TextColumn::make("start_date")
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make("end_date")
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make("users_count")
                    ->label("Participants")
                    ->counts("users")
                    ->sortable(),
                Tables\Columns\IconColumn::make("is_active")
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("difficulty_level")->options([
                    "easy" => "Easy",
                    "medium" => "Medium",
                    "hard" => "Hard",
                    "expert" => "Expert",
                ]),
                Tables\Filters\TernaryFilter::make("is_active")->label(
                    "Active Status"
                ),
                Tables\Filters\Filter::make("active_date")
                    ->form([
                        Forms\Components\DatePicker::make("start_date_from"),
                        Forms\Components\DatePicker::make("start_date_until"),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data["start_date_from"],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    "start_date",
                                    ">=",
                                    $date
                                )
                            )
                            ->when(
                                $data["start_date_until"],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    "start_date",
                                    "<=",
                                    $date
                                )
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make("manage_participants")
                    ->label("Participants")
                    ->icon("heroicon-s-users")
                    ->url(
                        fn(Challenge $record): string => static::getUrl(
                            "participants",
                            ["record" => $record]
                        )
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make("activate")
                        ->label("Activate Selected")
                        ->icon("heroicon-s-check-circle")
                        ->action(
                            fn(Collection $records) => $records->each->update([
                                "is_active" => true,
                            ])
                        ),
                    Tables\Actions\BulkAction::make("deactivate")
                        ->label("Deactivate Selected")
                        ->icon("heroicon-s-x-circle")
                        ->action(
                            fn(Collection $records) => $records->each->update([
                                "is_active" => false,
                            ])
                        ),
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
            "index" => Pages\ListChallenges::route("/"),
            "create" => Pages\CreateChallenge::route("/create"),
            "edit" => Pages\EditChallenge::route("/{record}/edit"),
            "participants" => Pages\ManageChallengeParticipants::route(
                "/{record}/participants"
            ),
        ];
    }
}
