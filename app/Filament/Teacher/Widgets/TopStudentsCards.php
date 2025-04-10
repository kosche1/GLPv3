<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

class TopStudentsCards extends Widget
{
    protected static ?int $sort = 4;
    protected static string $view = 'filament.teacher.widgets.top-students-cards';

    protected int | string | array $columnSpan = 'full';

    public function getTopStudents()
    {
        return User::query()
            ->role('student')
            ->join('experiences', 'users.id', '=', 'experiences.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'experiences.experience_points',
                'experiences.level_id'
            )
            ->withCount(['studentAnswers' => function ($query) {
                $query->where('is_correct', true);
            }])
            ->orderBy('experiences.experience_points', 'desc')
            ->limit(5)
            ->get();
    }
}
