<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\RecipeTemplateResource\Pages;
use App\Models\RecipeIngredient;
use App\Models\RecipeTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecipeTemplateResource extends Resource
{
    protected static ?string $model = RecipeTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'Recipe Challenges';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('difficulty_level')
                            ->options([
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('points_reward')
                            ->numeric()
                            ->required()
                            ->default(100),
                        Forms\Components\TextInput::make('max_ingredients')
                            ->numeric()
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Nutritional Requirements')
                    ->schema([
                        Forms\Components\TextInput::make('target_calories_min')
                            ->label('Minimum Calories')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('target_calories_max')
                            ->label('Maximum Calories')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('target_protein_min')
                            ->label('Minimum Protein (g)')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\TextInput::make('target_protein_max')
                            ->label('Maximum Protein (g)')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\TextInput::make('target_carbs_min')
                            ->label('Minimum Carbs (g)')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\TextInput::make('target_carbs_max')
                            ->label('Maximum Carbs (g)')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\TextInput::make('target_fat_min')
                            ->label('Minimum Fat (g)')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\TextInput::make('target_fat_max')
                            ->label('Maximum Fat (g)')
                            ->numeric()
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Ingredient Requirements')
                    ->schema([
                        Forms\Components\CheckboxList::make('required_categories')
                            ->label('Required Food Categories')
                            ->options([
                                'protein' => 'Protein',
                                'vegetable' => 'Vegetables',
                                'fruit' => 'Fruits',
                                'grain' => 'Grains',
                                'dairy' => 'Dairy',
                                'fat' => 'Fats & Oils',
                                'spice' => 'Spices & Herbs',
                            ]),
                        Forms\Components\Select::make('required_ingredients')
                            ->label('Required Ingredients')
                            ->multiple()
                            ->options(function () {
                                return RecipeIngredient::orderBy('name')->pluck('name', 'id')->toArray();
                            })
                            ->searchable(),
                        Forms\Components\Select::make('forbidden_ingredients')
                            ->label('Forbidden Ingredients')
                            ->multiple()
                            ->options(function () {
                                return RecipeIngredient::orderBy('name')->pluck('name', 'id')->toArray();
                            })
                            ->searchable(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('difficulty_level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'success',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('points_reward')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_calories_min')
                    ->label('Min Calories')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_calories_max')
                    ->label('Max Calories')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_ingredients')
                    ->label('Max Ingredients')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty_level')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('submissions')
                    ->label('View Submissions')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (RecipeTemplate $record) => route('filament.teacher.resources.user-recipes.index', ['template_id' => $record->id])),
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
            'index' => Pages\ListRecipeTemplates::route('/'),
            'create' => Pages\CreateRecipeTemplate::route('/create'),
            'edit' => Pages\EditRecipeTemplate::route('/{record}/edit'),
            'view' => Pages\ViewRecipeTemplate::route('/{record}'),
        ];
    }
}
