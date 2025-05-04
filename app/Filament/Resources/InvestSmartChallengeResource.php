<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestSmartChallengeResource\Pages;
use App\Models\InvestmentChallenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InvestSmartChallengeResource extends Resource
{
    protected static ?string $model = InvestmentChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'InvestSmart';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Challenge Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('starting_capital')
                            ->label('Starting Capital (₱)')
                            ->numeric()
                            ->required()
                            ->default(100000),
                        Forms\Components\TextInput::make('target_return')
                            ->label('Target Return (%)')
                            ->numeric()
                            ->required()
                            ->default(10),
                        Forms\Components\TextInput::make('duration_days')
                            ->label('Duration (Days)')
                            ->numeric()
                            ->required()
                            ->default(30),
                        Forms\Components\TextInput::make('points_reward')
                            ->label('Points Reward')
                            ->numeric()
                            ->required()
                            ->default(100),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Challenge Requirements')
                    ->schema([
                        Forms\Components\Repeater::make('required_stocks')
                            ->label('Required Stocks')
                            ->schema([
                                Forms\Components\TextInput::make('symbol')
                                    ->required()
                                    ->maxLength(10),
                                Forms\Components\TextInput::make('min_percentage')
                                    ->label('Minimum Portfolio %')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->collapsible(),
                        
                        Forms\Components\Repeater::make('forbidden_stocks')
                            ->label('Forbidden Stocks')
                            ->schema([
                                Forms\Components\TextInput::make('symbol')
                                    ->required()
                                    ->maxLength(10),
                            ])
                            ->columns(1)
                            ->collapsible(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'beginner' => 'success',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('starting_capital')
                    ->numeric()
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_return')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->numeric()
                    ->suffix(' days')
                    ->sortable(),
                Tables\Columns\TextColumn::make('points_reward')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Challenges')
                    ->trueLabel('Active Challenges')
                    ->falseLabel('Inactive Challenges'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('submissions')
                    ->label('View Submissions')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (InvestmentChallenge $record) => route('filament.admin.resources.investment-challenge-submissions.index', ['challenge_id' => $record->id])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $records->each(function ($record) {
                                $record->is_active = true;
                                $record->save();
                            });
                        }),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $records->each(function ($record) {
                                $record->is_active = false;
                                $record->save();
                            });
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
            'index' => Pages\ListInvestSmartChallenges::route('/'),
            'create' => Pages\CreateInvestSmartChallenge::route('/create'),
            'edit' => Pages\EditInvestSmartChallenge::route('/{record}/edit'),
            'view' => Pages\ViewInvestSmartChallenge::route('/{record}'),
        ];
    }
}
