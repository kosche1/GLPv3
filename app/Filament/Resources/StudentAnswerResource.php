<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentAnswerResource\Pages;
use App\Filament\Resources\StudentAnswerResource\RelationManagers;
use App\Models\StudentAnswer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentAnswerResource extends Resource
{
    protected static ?string $model = StudentAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Assessments';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->required(),
            Forms\Components\Select::make('task_id')
                ->relationship('task', 'name')
                ->required(),
            Forms\Components\KeyValue::make('student_answer')
                ->required(),
            Forms\Components\Textarea::make('solution')
                ->columnSpan(2)
                ->rows(10),
            Forms\Components\Textarea::make('output')
                ->columnSpan(2)
                ->rows(5),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'submitted' => 'Submitted',
                    'reviewed' => 'Reviewed',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->required(),
            Forms\Components\Toggle::make('is_correct')
                ->label('Correct'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('task.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'submitted' => 'blue',
                        'reviewed' => 'yellow',
                        'approved' => 'green',
                        'rejected' => 'red',
                        default => 'gray',
                    }),
                Tables\Columns\BooleanColumn::make('is_correct')
                    ->label('Correct'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name'),
                Tables\Filters\SelectFilter::make('task')
                    ->relationship('task', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'submitted' => 'Submitted',
                        'reviewed' => 'Reviewed',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\TernaryFilter::make('is_correct')
                    ->label('Correct Answers'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListStudentAnswers::route('/'),
            'create' => Pages\CreateStudentAnswer::route('/create'),
            'edit' => Pages\EditStudentAnswer::route('/{record}/edit'),
        ];
    }
}
