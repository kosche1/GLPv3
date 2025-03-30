<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;

class CourseDevelopment extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Course Development';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Teaching';

    protected static string $view = 'filament.teacher.pages.course-development';
}