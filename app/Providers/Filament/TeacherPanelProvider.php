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
            ->authGuard('web')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                'Teaching',
                'Communication',
                'Analytics',
                'SHS Specialized Subjects',
            ])
            ->discoverResources(in: app_path('Filament/Teacher/Resources'), for: 'App\\Filament\\Teacher\\Resources')
            ->discoverPages(in: app_path('Filament/Teacher/Pages'), for: 'App\\Filament\\Teacher\\Pages')
            ->pages([
                Pages\Dashboard::class,

                \App\Filament\Teacher\Pages\AssessmentTools::class,
                \App\Filament\Teacher\Pages\StudentAnalytics::class,
                \App\Filament\Teacher\Pages\StudentAttendancePage::class,
                \App\Filament\Teacher\Pages\GameProgressPage::class,
            ])
            // Register only the widgets we need
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                \App\Filament\Teacher\Widgets\TeacherDashboardWidget::class,
                \App\Filament\Teacher\Widgets\StudentStatsWidget::class,
                \App\Filament\Teacher\Widgets\TopStudentsTable::class,
                \App\Filament\Teacher\Widgets\ChallengeCompletionTable::class,
                \App\Filament\Teacher\Widgets\StudentProgressTable::class,
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
                \App\Http\Middleware\LogFilamentLogout::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->tenantMiddleware([
                // Ensure only faculty members can access the teacher panel
                function () {
                    return function ($request, $next) {
                        $user = $request->user();

                        if (!$user || !$user->hasRole('faculty')) {
                            // Redirect non-faculty users to the dashboard
                            return redirect()->route('dashboard')
                                ->with('error', 'You do not have permission to access the teacher panel.');
                        }

                        return $next($request);
                    };
                },
            ]);
    }
}
