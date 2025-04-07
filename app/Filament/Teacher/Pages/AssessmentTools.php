<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use App\Models\StudentAnswer;
use App\Models\User;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class AssessmentTools extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Assessment Tools';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Teaching';

    protected static string $view = 'filament.teacher.pages.assessment-tools';

    public function getTitle(): string
    {
        return 'Assessment Tools';
    }

    public function getSubheading(): ?string
    {
        return 'Evaluate student submissions and provide feedback';
    }
}
