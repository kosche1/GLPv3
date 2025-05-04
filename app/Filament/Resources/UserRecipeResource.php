<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRecipeResource\Pages;
use App\Models\UserRecipe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Actions\Action;

class UserRecipeResource extends Resource
{
    protected static ?string $model = UserRecipe::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'Recipe Builder';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Recipe Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->disabled(),
                        Forms\Components\Select::make('recipe_template_id')
                            ->relationship('recipeTemplate', 'name')
                            ->disabled(),
                        Forms\Components\TextInput::make('score')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('potential_points')
                            ->numeric()
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Nutritional Information')
                    ->schema([
                        Forms\Components\TextInput::make('total_calories')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('total_protein')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('total_carbs')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('total_fat')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\Toggle::make('is_balanced')
                            ->disabled(),
                        Forms\Components\Toggle::make('meets_requirements')
                            ->disabled(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Approval')
                    ->schema([
                        Forms\Components\Toggle::make('points_awarded')
                            ->label('Award Points')
                            ->helperText('Toggle to award points to the student for this recipe')
                            ->default(false),
                        Forms\Components\Textarea::make('feedback')
                            ->label('Feedback for Student')
                            ->placeholder('Provide feedback about the recipe')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipeTemplate.name')
                    ->label('Template')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_balanced')
                    ->boolean(),
                Tables\Columns\IconColumn::make('meets_requirements')
                    ->boolean(),
                Tables\Columns\TextColumn::make('potential_points')
                    ->label('Points')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('points_awarded')
                    ->boolean()
                    ->label('Approved'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('points_awarded')
                    ->options([
                        '0' => 'Pending Approval',
                        '1' => 'Approved',
                    ])
                    ->label('Approval Status'),
                Tables\Filters\SelectFilter::make('is_balanced')
                    ->options([
                        '0' => 'Not Balanced',
                        '1' => 'Balanced',
                    ]),
                Tables\Filters\SelectFilter::make('meets_requirements')
                    ->options([
                        '0' => 'Does Not Meet Requirements',
                        '1' => 'Meets Requirements',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve & Award Points')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (UserRecipe $record) => !$record->points_awarded)
                    ->requiresConfirmation()
                    ->modalHeading('Approve Recipe')
                    ->modalDescription(fn (UserRecipe $record) => "Are you sure you want to approve {$record->name} by {$record->user->name}? This will award {$record->potential_points} points to the student.")
                    ->modalSubmitActionLabel('Yes, Approve Recipe')
                    ->action(function (UserRecipe $record) {
                        // Award points to the user
                        $user = $record->user;
                        $pointsToAward = $record->potential_points;

                        // Update the recipe record
                        $record->points_awarded = true;
                        $record->notification_shown = false; // Set to false so notification will be shown to student
                        $record->points_awarded_at = now();
                        $record->approved_by = Auth::id();
                        $record->save();

                        // Award the points
                        $user->addPoints(
                            amount: $pointsToAward,
                            reason: "Recipe approved: {$record->name}"
                        );

                        // Show notification in the bell and persist it
                        Notification::make()
                            ->success()
                            ->title('Points Awarded')
                            ->body("Awarded {$pointsToAward} points to {$user->name} for recipe {$record->name}")
                            ->persistent()
                            ->actions([
                                Action::make('view')
                                    ->button()
                                    ->url(route('filament.admin.resources.user-recipes.edit', $record))
                            ])
                            ->send();

                        // Show a popup notification that stays longer
                        Notification::make('admin-approval-success')
                            ->success()
                            ->title('Recipe Approved Successfully!')
                            ->body("You have approved {$record->name} by {$user->name} and awarded {$pointsToAward} points.")
                            ->duration(15000) // Show for 15 seconds
                            ->icon('heroicon-o-check-circle')
                            ->iconColor('success')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approveMultiple')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Approve Selected Recipes')
                        ->modalDescription('Are you sure you want to approve all selected recipes? This will award points to the students.')
                        ->modalSubmitActionLabel('Yes, Approve All Selected')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = 0;
                            $totalPoints = 0;

                            foreach ($records as $record) {
                                if (!$record->points_awarded) {
                                    $user = $record->user;
                                    $pointsToAward = $record->potential_points;

                                    // Update the recipe record
                                    $record->points_awarded = true;
                                    $record->notification_shown = false; // Set to false so notification will be shown to student
                                    $record->points_awarded_at = now();
                                    $record->approved_by = Auth::id();
                                    $record->save();

                                    // Award the points
                                    $user->addPoints(
                                        amount: $pointsToAward,
                                        reason: "Recipe approved: {$record->name}"
                                    );

                                    $count++;
                                    $totalPoints += $pointsToAward;
                                }
                            }

                            if ($count > 0) {
                                // Persistent notification for the bell
                                Notification::make()
                                    ->success()
                                    ->title('Recipes Approved')
                                    ->body("Approved {$count} recipes and awarded a total of {$totalPoints} points")
                                    ->persistent()
                                    ->send();

                                // Popup notification that stays longer
                                Notification::make('admin-bulk-approval-success')
                                    ->success()
                                    ->title('Recipes Approved Successfully!')
                                    ->body("You have approved {$count} recipes and awarded a total of {$totalPoints} points to students.")
                                    ->duration(15000) // Show for 15 seconds
                                    ->icon('heroicon-o-check-circle')
                                    ->iconColor('success')
                                    ->send();
                            } else {
                                // Persistent notification for the bell
                                Notification::make()
                                    ->warning()
                                    ->title('No Recipes Approved')
                                    ->body("No recipes were eligible for approval")
                                    ->persistent()
                                    ->send();

                                // Popup notification that stays longer
                                Notification::make('admin-bulk-approval-warning')
                                    ->warning()
                                    ->title('No Recipes Approved')
                                    ->body("No recipes were eligible for approval. Make sure you've selected recipes that haven't been approved yet.")
                                    ->duration(15000) // Show for 15 seconds
                                    ->icon('heroicon-o-exclamation-triangle')
                                    ->iconColor('warning')
                                    ->send();
                            }
                        }),
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
            'index' => Pages\ListUserRecipes::route('/'),
            'create' => Pages\CreateUserRecipe::route('/create'),
            'edit' => Pages\EditUserRecipe::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'recipeTemplate']);
    }
}
