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
use App\Filament\Resources\ChallengeResource\RelationManagers\TasksRelationManager;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\DB;

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
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str($state)->slug())),
                Forms\Components\Textarea::make("description")
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make("category_id")
                    ->relationship("category", "name")
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str($state)->slug())),
                    Forms\Components\TextInput::make('description')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique('categories', 'slug', ignoreRecord: true),
                    ]),
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make("subject_type_id")
                            ->label("Subject Type")
                            ->relationship("subjectType", "name")
                            ->preload()
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('strand_id', null)),
                        Forms\Components\Select::make("strand_id")
                            ->label("Strand")
                            ->relationship("strand", "name")
                            ->preload()
                            ->searchable()
                            ->required(fn (callable $get) => $get('subject_type_id') && \App\Models\SubjectType::find($get('subject_type_id'))?->code === 'specialized')
                            ->visible(fn (callable $get) => $get('subject_type_id') && \App\Models\SubjectType::find($get('subject_type_id'))?->code === 'specialized')
                            ->helperText("Select the strand (HUMMS, ICT, etc.)"),
                    ]),
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
                FileUpload::make('image')
                    ->disk('public')
                    ->directory('challenge-images')
                    ->image()
                    ->imageEditor()
                    ->helperText('Upload an image (saved to public/images)')
                    ->columnSpanFull(),
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
                ->options([
                    "debugging" => "Debugging Exercise",
                    "algorithm" => "Algorithm Challenge",
                    "database" => "Database Challenge",
                    "ui_design" => "UI/UX Challenge",
                    "problem_solving" => "Problem Solving Challenge",
                    "essay" => "Essay Challenge",
                    "language" => "Language Challenge",
                    "research" => "Research Challenge",
                    "creative" => "Creative Challenge",
                    "data_visualization" => "Data Visualization Challenge",
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
                    "java" => "Java",
                    "csharp" => "C#",
                    "php" => "PHP",
                    "sql" => "SQL",
                    "none" => "Not Language Specific",
                ])
                ->default("none")
                ->visible(function (Forms\Get $get) {
                    return in_array($get("challenge_type"), [
                        "coding_challenge", "debugging", "algorithm", "project", "code_review"
                    ]);
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

                // If no challenge type is selected, return empty schema
                if (empty($challengeType)) {
                    return [
                        Forms\Components\Placeholder::make("no_type_selected")
                            ->content('Select a challenge type to configure specific content.')
                            ->columnSpanFull(),
                    ];
                }

                return match ($challengeType) {
                    "debugging" => [
                        Forms\Components\Textarea::make("challenge_content.scenario")
                            ->label("Debugging Scenario")
                            ->required()
                            ->hint('Provide a scenario where the user is expected to debug the given code.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.buggy_code")
                            ->label("Code with Bugs")
                            ->required()
                            ->hint('Provide the code that contains bugs.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.expected_behavior")
                            ->label("Expected Behavior")
                            ->required()
                            ->hint('What should the code look like after debugging?'),
                        Forms\Components\Textarea::make("challenge_content.current_behavior")
                            ->label("Current Behavior")
                            ->required()
                            ->hint('What is the current behavior of the code?'),
                        // Forms\Components\Repeater::make("challenge_content.hints")
                        //     ->label("Hints")
                        //     ->schema([
                        //         Forms\Components\TextInput::make("hint")
                        //             ->required(),
                        //     ])
                        //     ->defaultItems(3),
                    ],

                    "algorithm" => [
                        Forms\Components\Textarea::make("challenge_content.problem_statement")
                            ->label("Algorithm Problem")
                            ->required()
                            ->hint('Describe the problem and provide a clear statement.')
                            ->columnSpanFull(),
                        Forms\Components\Select::make("challenge_content.algorithm_type")
                            ->label("Algorithm Type")
                            ->hint('Select the type of algorithm.')
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
                            ->hint('Provide an example of the algorithm in action.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.solution_approach")
                            ->label("Solution Approach")
                            ->hint('Describe the approach to solving the algorithm.')
                            ->columnSpanFull(),
                    ],

                    "database" => [
                        Forms\Components\Textarea::make("challenge_content.scenario")
                            ->label("Database Scenario")
                            ->required()
                            ->hint('Describe the scenario for the database challenge.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.schema")
                            ->label("Database Schema")
                            ->required()
                            ->hint('Provide the database schema.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.tasks")
                            ->label("SQL Tasks")
                            ->required()
                            ->hint('List the tasks for the database challenge.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.sample_data")
                            ->label("Sample Data")
                            ->required()
                            ->hint('Provide sample data for the database challenge.')
                            ->columnSpanFull(),
                    ],

                    "ui_design" => [
                        Forms\Components\Textarea::make("challenge_content.design_brief")
                            ->label("Design Brief")
                            ->required()
                            ->hint('"Provide a brief description of the UI/UX challenge."')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.requirements")
                            ->label("UI/UX Requirements")
                            ->required()
                            ->hint('Provide the requirements for the UI/UX challenge.')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make("challenge_content.assets")
                            ->label("Design Assets")
                            ->multiple()
                            ->hint('Upload any design assets for the UI/UX challenge.')
                            ->directory("ui_challenges"),
                        Forms\Components\Textarea::make("challenge_content.evaluation_criteria")
                            ->label("Evaluation Criteria")
                            ->required()
                            ->hint('Describe the evaluation criteria for the UI/UX challenge.')
                            ->columnSpanFull(),
                    ],

                    // Add cases for other common challenge types based on seeder structure
                    "problem_solving",
                    "essay",
                    "language",
                    "research",
                    "creative",
                    "data_visualization" => [
                        Forms\Components\Textarea::make("challenge_content.problem_statement")
                            ->label("Problem Statement / Task Overview")
                            ->required()
                            ->hint('Describe the main goal or problem the user needs to address.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.sections")
                            ->label("Detailed Instructions / Sections / Requirements")
                            ->required()
                            ->hint('Provide detailed steps, parts, specific requirements, or different sections of the challenge.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make("challenge_content.evaluation_criteria")
                            ->label("Evaluation Criteria")
                            ->required()
                            ->hint('How will the submission be evaluated?')
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
            Tables\Columns\TextColumn::make("category.name")
                ->label("Category")
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make("subjectType.name")
                ->label("Subject Type")
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make("strand.name")
                ->label("Strand")
                ->sortable()
                ->searchable(),
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
            Tables\Filters\SelectFilter::make("subject_type_id")
                ->label("Subject Type")
                ->relationship("subjectType", "name"),
            Tables\Filters\SelectFilter::make("strand_id")
                ->label("Strand")
                ->relationship("strand", "name"),
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
                                'end_date' => DB::raw('NOW() + INTERVAL 7 DAY')
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
    TasksRelationManager::class,
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