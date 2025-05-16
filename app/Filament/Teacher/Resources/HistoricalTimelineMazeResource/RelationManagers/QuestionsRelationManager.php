<?php

namespace App\Filament\Teacher\Resources\HistoricalTimelineMazeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'question';

    protected static ?string $title = 'Historical Timeline Maze Questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Select::make('era')
                            ->options([
                                'ancient' => 'Ancient History (3000 BCE - 500 CE)',
                                'medieval' => 'Medieval Period (500 - 1500 CE)',
                                'renaissance' => 'Renaissance & Early Modern (1500 - 1800 CE)',
                                'modern' => 'Modern Era (1800 - 1945 CE)',
                                'contemporary' => 'Contemporary History (1945 - Present)',
                            ])
                            ->required(),
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'easy' => 'Easy',
                                'medium' => 'Medium',
                                'hard' => 'Hard',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('points')
                            ->numeric()
                            ->default(100)
                            ->required(),
                    ]),

                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('hint')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Answers')
                    ->description('Define the possible answers. Mark one option as correct.')
                    ->schema([
                        Forms\Components\Repeater::make('options')
                            ->schema([
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\TextInput::make('id')
                                            ->numeric()
                                            ->required()
                                            ->label('ID'),
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->label('Event Title')
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('year')
                                            ->required()
                                            ->label('Year/Period'),
                                    ]),
                                Forms\Components\Toggle::make('correct')
                                    ->required()
                                    ->label('Is Correct Answer')
                                    ->default(false),
                            ])
                            ->columns(1)
                            ->required()
                            ->minItems(2)
                            ->maxItems(4)
                            ->defaultItems(3)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->afterStateHydrated(function ($state, callable $set) {
                                // If options is NULL, initialize it with default structure
                                if (is_null($state)) {
                                    $set('options', [
                                        [
                                            'id' => 1,
                                            'title' => 'Option 1',
                                            'year' => '1000 BCE',
                                            'correct' => true
                                        ],
                                        [
                                            'id' => 2,
                                            'title' => 'Option 2',
                                            'year' => '500 BCE',
                                            'correct' => false
                                        ],
                                        [
                                            'id' => 3,
                                            'title' => 'Option 3',
                                            'year' => '100 BCE',
                                            'correct' => false
                                        ]
                                    ]);
                                }
                            }),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('era')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ancient' => 'info',
                        'medieval' => 'success',
                        'renaissance' => 'warning',
                        'modern' => 'danger',
                        'contemporary' => 'gray',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('question')
                    ->searchable()
                    ->limit(30),
                // Answer column removed
                Tables\Columns\TextColumn::make('points')
                    ->label('Points')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('era')
                    ->options([
                        'ancient' => 'Ancient History',
                        'medieval' => 'Medieval Period',
                        'renaissance' => 'Renaissance & Early Modern',
                        'modern' => 'Modern Era',
                        'contemporary' => 'Contemporary History',
                    ]),
                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Questions')
                    ->trueLabel('Active Questions')
                    ->falseLabel('Inactive Questions'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order')
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('difficulty')->orderBy('order'));
    }
}
