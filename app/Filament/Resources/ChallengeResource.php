<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Challenge;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ChallengeResource\Pages;

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
                Forms\Components\Select::make("difficulty_level")
                    ->options([
                        "beginner" => "Beginner",
                        "intermediate" => "Intermediate",
                        "advanced" => "Advanced",
                        "expert" => "Expert",
                    ])
                    ->required(),
                Forms\Components\TextInput::make("points_reward")
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make("is_active")
                    ->default(true),
                Forms\Components\TextInput::make("max_participants")
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make("required_level")
                    ->numeric()
                    ->minValue(1)
                    ->default(1),
            ]),

            Forms\Components\Section::make("Challenge Configuration")->schema([
                Forms\Components\Select::make("challenge_type")
                ->label("Challenge Type")
                ->required()
                ->options([
                    "coding_challenge" => "Coding Challenge",
                    "debugging" => "Debugging Exercise",
                    "algorithm" => "Algorithm Challenge",
                    "quiz" => "Technical Quiz",
                    "flashcard" => "Technical Flashcards",
                    "project" => "Mini Project",
                    "code_review" => "Code Review Challenge",
                    "database" => "Database Challenge",
                    "security" => "Security Challenge",
                    "ui_design" => "UI/UX Challenge",
                ])
                ->default("coding_challenge")
                ->reactive()
                ->afterStateUpdated(function (callable $set) {
                    $set("challenge_content", []);
                }),

            Forms\Components\Select::make("programming_language")
                ->label("Programming Language")
                ->options([
                    "python" => "Python",
                    "javascript" => "JavaScript",
                    "java" => "Java",
                    "csharp" => "C#",
                    "cpp" => "C++",
                    "php" => "PHP",
                    "ruby" => "Ruby",
                    "swift" => "Swift",
                    "go" => "Go",
                    "sql" => "SQL",
                    "multiple" => "Multiple Languages",
                    "none" => "Not Language Specific",
                ])
                ->default("none")
                ->visible(fn (Forms\Get $get) => in_array($get("challenge_type"), [
                    "coding_challenge", "debugging", "algorithm", "project", "code_review"
                ])),

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
                    "coding_challenge" => [
                        Forms\Components\Textarea::make("challenge_content.problem_statement")
                            ->label("Problem Statement")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.input_format")
                            ->label("Input Format")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.output_format")
                            ->label("Output Format")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.constraints")
                            ->label("Constraints")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.sample_input")
                            ->label("Sample Input")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.sample_output")
                            ->label("Sample Output")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.explanation")
                            ->label("Explanation")
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.starter_code")
                            ->label("Starter Code")
                            ->columnSpanFull(),
                    ],

                    "debugging" => [
                        Forms\Components\Textarea::make("challenge_content.scenario")
                            ->label("Debugging Scenario")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.buggy_code")
                            ->label("Code with Bugs")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.expected_behavior")
                            ->label("Expected Behavior")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.current_behavior")
                            ->label("Current Behavior")
                            ->required(),
                        Forms\Components\Repeater::make("challenge_content.hints")
                            ->label("Hints")
                            ->schema([
                                Forms\Components\TextInput::make("hint")
                                    ->required(),
                            ])
                            ->defaultItems(3),
                    ],

                    "algorithm" => [
                        Forms\Components\Textarea::make("challenge_content.problem_statement")
                            ->label("Algorithm Problem")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make("challenge_content.algorithm_type")
                            ->label("Algorithm Type")
                            ->options([
                                "sorting" => "Sorting",
                                "searching" => "Searching",
                                "graph" => "Graph Algorithms",
                                "dynamic" => "Dynamic Programming",
                                "greedy" => "Greedy Algorithms",
                                "recursion" => "Recursion",
                                "other" => "Other",
                            ])
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.example")
                            ->label("Example")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.solution_approach")
                            ->label("Solution Approach")
                            ->columnSpanFull(),
                    ],

                    "quiz" => [
                        Forms\Components\Repeater::make("challenge_content.questions")
                            ->label("Technical Quiz Questions")
                            ->schema([
                                Forms\Components\TextInput::make("question")
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Repeater::make("options")
                                    ->schema([
                                        Forms\Components\TextInput::make("text")
                                            ->required(),
                                        Forms\Components\Toggle::make("is_correct")
                                            ->label("Correct Answer")
                                            ->default(false),
                                    ])
                                    ->defaultItems(4)
                                    ->columns(2),
                                Forms\Components\TextInput::make("points")
                                    ->numeric()
                                    ->default(1)
                                    ->label("Points for correct answer"),
                                Forms\Components\Textarea::make("explanation")
                                    ->label("Explanation (shown after answering)")
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(5)
                            ->collapsible()
                            ->columnSpanFull(),
                    ],

                    "flashcard" => [
                        Forms\Components\Repeater::make("challenge_content.cards")
                            ->label("Technical Flashcards")
                            ->schema([
                                Forms\Components\TextInput::make("term")
                                    ->label("Technical Term")
                                    ->required(),
                                Forms\Components\Textarea::make("definition")
                                    ->label("Definition")
                                    ->required(),
                                Forms\Components\FileUpload::make("image")
                                    ->label("Illustration (Optional)")
                                    ->image()
                                    ->directory("flashcards"),
                                Forms\Components\TextInput::make("code_example")
                                    ->label("Code Example (Optional)")
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(5)
                            ->collapsible()
                            ->columnSpanFull(),
                    ],

                    "project" => [
                        Forms\Components\Textarea::make("challenge_content.project_brief")
                            ->label("Project Brief")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.requirements")
                            ->label("Technical Requirements")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.deliverables")
                            ->label("Deliverables")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.evaluation_criteria")
                            ->label("Evaluation Criteria")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.resources")
                            ->label("Helpful Resources")
                            ->columnSpanFull(),
                    ],

                    "code_review" => [
                        Forms\Components\Textarea::make("challenge_content.code_to_review")
                            ->label("Code to Review")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.context")
                            ->label("Code Context")
                            ->required(),
                        Forms\Components\Textarea::make("challenge_content.review_guidelines")
                            ->label("Review Guidelines")
                            ->required(),
                        Forms\Components\Repeater::make("challenge_content.issues")
                            ->label("Known Issues (Hidden from participants)")
                            ->schema([
                                Forms\Components\TextInput::make("issue")
                                    ->required(),
                                Forms\Components\Select::make("severity")
                                    ->options([
                                        "critical" => "Critical",
                                        "major" => "Major",
                                        "minor" => "Minor",
                                        "improvement" => "Improvement",
                                    ])
                                    ->required(),
                            ])
                            ->defaultItems(3)
                            ->columnSpanFull(),
                    ],

                    "database" => [
                        Forms\Components\Textarea::make("challenge_content.scenario")
                            ->label("Database Scenario")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.schema")
                            ->label("Database Schema")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.tasks")
                            ->label("SQL Tasks")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.sample_data")
                            ->label("Sample Data")
                            ->required()
                            ->columnSpanFull(),
                    ],

                    "security" => [
                        Forms\Components\Textarea::make("challenge_content.scenario")
                            ->label("Security Scenario")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.vulnerable_code")
                            ->label("Vulnerable Code/System")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make("challenge_content.tasks")
                            ->label("Security Tasks")
                            ->schema([
                                Forms\Components\TextInput::make("task")
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make("points")
                                    ->numeric()
                                    ->default(1),
                            ])
                            ->defaultItems(3)
                            ->columnSpanFull(),
                    ],

                    "ui_design" => [
                        Forms\Components\Textarea::make("challenge_content.design_brief")
                            ->label("Design Brief")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.requirements")
                            ->label("UI/UX Requirements")
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make("challenge_content.assets")
                            ->label("Design Assets")
                            ->multiple()
                            ->directory("ui_challenges"),
                        Forms\Components\Textarea::make("challenge_content.evaluation_criteria")
                            ->label("Evaluation Criteria")
                            ->required()
                            ->columnSpanFull(),
                    ],

                    default => [
                        Forms\Components\Placeholder::make("standard_note")
                            ->content(
                                'Please select a challenge type to configure specific content.'
                            )
                            ->columnSpanFull(),
                    ],
                };
            })
            ->columnSpanFull(),
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
                    "primary" => "coding_challenge",
                    "success" => "debugging",
                    "warning" => "algorithm",
                    "danger" => "quiz",
                    "info" => "flashcard",
                    "secondary" => "project",
                    "gray" => "code_review",
                    "purple" => "database",
                    "red" => "security",
                    "blue" => "ui_design",
                ]),
            Tables\Columns\TextColumn::make("programming_language")
                ->label("Language"),
            Tables\Columns\BadgeColumn::make("difficulty_level")->colors([
                "success" => "beginner",
                "warning" => "intermediate",
                "danger" => "advanced",
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
                "coding_challenge" => "Coding Challenge",
                "debugging" => "Debugging Exercise",
                "algorithm" => "Algorithm Challenge",
                "quiz" => "Technical Quiz",
                "flashcard" => "Technical Flashcards",
                "project" => "Mini Project",
                "code_review" => "Code Review Challenge",
                "database" => "Database Challenge",
                "security" => "Security Challenge",
                "ui_design" => "UI/UX Challenge",
            ]),
            Tables\Filters\SelectFilter::make("programming_language")->options([
                "python" => "Python",
                "javascript" => "JavaScript",
                "java" => "Java",
                "csharp" => "C#",
                "cpp" => "C++",
                "php" => "PHP",
                "sql" => "SQL",
                "multiple" => "Multiple Languages",
                "none" => "Not Language Specific",
            ]),
            Tables\Filters\SelectFilter::make("difficulty_level")->options([
                "beginner" => "Beginner",
                "intermediate" => "Intermediate",
                "advanced" => "Advanced",
                "expert" => "Expert",
            ]),
            Tables\Filters\TernaryFilter::make("is_active")->label(
                "Active Status"
            ),
            // ... rest of your filters
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
        // Tables\Actions\Action::make("view_submissions")
        //     ->label("View Submissions")
        //     ->icon("heroicon-s-document-text")
        //     ->url(
        //         fn(Challenge $record): string => route(
        //             "challenges.submissions",
        //             ["challenge" => $record]
        //         )
        //     ),
    ])
    ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\BulkAction::make("activate")
                ->label("Activate Selected")
                ->icon("heroicon-o-check-badge")
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
            Tables\Actions\BulkAction::make("extend_deadline")
                ->label("Extend Deadline (7 days)")
                ->icon("heroicon-s-calendar")
                ->action(function (Collection $records) {
                    foreach ($records as $record) {
                        if ($record->end_date) {
                            $record->update([
                                'end_date' => $record->end_date->addDays(7)
                            ]);
                        } else {
                            $record->update([
                                'end_date' => now()->addDays(7)
                            ]);
                        }
                    }
                }),
        ]),
    ]);
}

public static function getEloquentQuery(): Builder
{
return parent::getEloquentQuery()
    ->withCount('users');
}

public static function getRelations(): array
{
return [
    // RelationManagers\BadgesRelationManager::class,
    // RelationManagers\AchievementsRelationManager::class,
    // RelationManagers\ActivitiesRelationManager::class,
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

public static function getNavigationBadge(): ?string
{
return static::getModel()::where('is_active', true)->count();
}
}