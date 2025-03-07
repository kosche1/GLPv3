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
                // Existing basic fields...
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
                // ... other existing fields
            ]),

            Forms\Components\Section::make("Challenge Configuration")->schema([
                Forms\Components\Select::make("challenge_type")
                    ->label("Challenge Type")
                    ->required()
                    ->options([
                        "standard" => "Standard Challenge",
                        "flashcard" => "Flashcard Challenge",
                        "crossword" => "Crossword Puzzle",
                        "word_search" => "Word Search",
                        "quiz" => "Quiz Challenge",
                    ])
                    ->default("standard")
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set("challenge_content", []);
                    }),

                Forms\Components\TextInput::make("time_limit")
                    ->label("Time Limit (minutes)")
                    ->numeric()
                    ->minValue(1)
                    ->placeholder("Leave empty for no time limit")
                    ->helperText(
                        "How long users have to complete this challenge"
                    ),
            ]),

            // Dynamic content section for each challenge type
            Forms\Components\Section::make("Challenge Content")
                ->schema(function (Forms\Get $get) {
                    $challengeType = $get("challenge_type");

                    return match ($challengeType) {
                        "flashcard" => [
                            Forms\Components\Repeater::make(
                                "challenge_content.cards"
                            )
                                ->label("Flashcards")
                                ->schema([
                                    Forms\Components\TextInput::make("front")
                                        ->label("Front of Card")
                                        ->required(),
                                    Forms\Components\Textarea::make("back")
                                        ->label("Back of Card")
                                        ->required(),
                                    Forms\Components\FileUpload::make("image")
                                        ->label("Card Image (Optional)")
                                        ->image()
                                        ->directory("flashcards"),
                                ])
                                ->defaultItems(3)
                                ->collapsible()
                                ->columnSpanFull(),
                        ],

                        "crossword" => [
                            Forms\Components\KeyValue::make(
                                "challenge_content.size"
                            )
                                ->label("Puzzle Size")
                                ->default([
                                    "width" => "10",
                                    "height" => "10",
                                ]),
                            Forms\Components\Repeater::make(
                                "challenge_content.words"
                            )
                                ->label("Crossword Words")
                                ->schema([
                                    Forms\Components\TextInput::make(
                                        "word"
                                    )->required(),
                                    Forms\Components\TextInput::make(
                                        "clue"
                                    )->required(),
                                    Forms\Components\Select::make("direction")
                                        ->options([
                                            "across" => "Across",
                                            "down" => "Down",
                                        ])
                                        ->default("across")
                                        ->required(),
                                ])
                                ->defaultItems(5)
                                ->collapsible()
                                ->columnSpanFull(),
                        ],

                        "word_search" => [
                            Forms\Components\KeyValue::make(
                                "challenge_content.size"
                            )
                                ->label("Puzzle Size")
                                ->default([
                                    "width" => "12",
                                    "height" => "12",
                                ]),
                            Forms\Components\Repeater::make(
                                "challenge_content.words"
                            )
                                ->label("Hidden Words")
                                ->schema([
                                    Forms\Components\TextInput::make(
                                        "word"
                                    )->required(),
                                    Forms\Components\TextInput::make(
                                        "hint"
                                    )->required(),
                                ])
                                ->defaultItems(8)
                                ->columnSpanFull(),
                        ],

                        "quiz" => [
                            Forms\Components\Repeater::make(
                                "challenge_content.questions"
                            )
                                ->label("Quiz Questions")
                                ->schema([
                                    Forms\Components\TextInput::make("question")
                                        ->required()
                                        ->columnSpanFull(),
                                    Forms\Components\Repeater::make("options")
                                        ->schema([
                                            Forms\Components\TextInput::make(
                                                "text"
                                            )->required(),
                                            Forms\Components\Toggle::make(
                                                "is_correct"
                                            )
                                                ->label("Correct Answer")
                                                ->default(false),
                                        ])
                                        ->defaultItems(4)
                                        ->columns(2),
                                    Forms\Components\TextInput::make("points")
                                        ->numeric()
                                        ->default(1)
                                        ->label("Points for correct answer"),
                                ])
                                ->defaultItems(5)
                                ->collapsible()
                                ->columnSpanFull(),
                        ],

                        default => [
                            Forms\Components\Placeholder::make("standard_note")
                                ->content(
                                    'Standard challenges don\'t require specific content configuration.'
                                )
                                ->columnSpanFull(),
                        ],
                    };
                })
                ->columnSpanFull(),

            // ... rest of your form sections
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\BadgeColumn::make("challenge_type")
                    ->label("Type")
                    ->colors([
                        "primary" => "standard",
                        "success" => "flashcard",
                        "warning" => "crossword",
                        "danger" => "word_search",
                        "info" => "quiz",
                    ]),
                Tables\Columns\BadgeColumn::make("difficulty_level")->colors([
                    "success" => "easy",
                    "warning" => "medium",
                    "danger" => "hard",
                    "gray" => "expert",
                ]),
                Tables\Columns\TextColumn::make("time_limit")
                    ->label("Time Limit")
                    ->formatStateUsing(
                        fn($state) => $state ? "{$state} min" : "No limit"
                    ),
                Tables\Columns\TextColumn::make("points_reward")->sortable(),
                Tables\Columns\TextColumn::make("start_date")
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
                Tables\Filters\SelectFilter::make("challenge_type")->options([
                    "standard" => "Standard Challenge",
                    "flashcard" => "Flashcard Challenge",
                    "crossword" => "Crossword Puzzle",
                    "word_search" => "Word Search",
                    "quiz" => "Quiz Challenge",
                ]),
                Tables\Filters\SelectFilter::make("difficulty_level")->options([
                    "easy" => "Easy",
                    "medium" => "Medium",
                    "hard" => "Hard",
                    "expert" => "Expert",
                ]),
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
