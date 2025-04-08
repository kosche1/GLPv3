<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TeacherPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teacher')
            ->path('teacher')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                'Teaching',
                'Communication',
                'Analytics',
            ])
            ->discoverResources(in: app_path('Filament/Teacher/Resources'), for: 'App\\Filament\\Teacher\\Resources')
            ->discoverPages(in: app_path('Filament/Teacher/Pages'), for: 'App\\Filament\\Teacher\\Pages')
            ->pages([
                Pages\Dashboard::class,

                \App\Filament\Teacher\Pages\AssessmentTools::class,
                \App\Filament\Teacher\Pages\Feedback::class,
                \App\Filament\Teacher\Pages\StudentAnalytics::class,
                \App\Filament\Teacher\Pages\StudentAttendancePage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Teacher/Widgets'), for: 'App\\Filament\\Teacher\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                \App\Filament\Teacher\Widgets\StudentStats::class,
                \App\Filament\Teacher\Widgets\RecentActivities::class,
                \App\Filament\Teacher\Widgets\TopStudentsTable::class,
                \App\Filament\Teacher\Widgets\ChallengeCompletionTable::class,
                \App\Filament\Teacher\Widgets\StudentProgressTable::class,
                \App\Filament\Teacher\Widgets\UpcomingTasks::class,
                \App\Filament\Teacher\Widgets\TopStudents::class,
                \App\Filament\Teacher\Widgets\ChallengeCompletion::class,
            ])
            // Livewire components are registered in TeacherWidgetsServiceProvider
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
