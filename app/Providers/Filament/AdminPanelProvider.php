<?php

namespace App\Providers\Filament;

use AssistantEngine\Filament\FilamentAssistantPlugin;
use App\Filament\Resources\UserResource\Widgets\UserStats;
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
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id("admin")
            ->authGuard("admin")
            ->path("admin")
            ->login()
            ->colors([
                "primary" => Color::Purple,
            ])
            ->discoverResources(
                in: app_path("Filament/Resources"),
                for: "App\\Filament\\Resources"
            )
            ->discoverPages(
                in: app_path("Filament/Pages"),
                for: "App\\Filament\\Pages"
            )
            // ->pages([Pages\Dashboard::class,
            // \AssistantEngine\Filament\Chat\Pages\AssistantChat::class,
            // \App\Filament\Pages\Reports::class,
            // ])
            ->discoverWidgets(
                in: app_path("Filament/Widgets"),
                for: "App\\Filament\\Widgets"
            )
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                UserStats::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                FilamentAssistantPlugin::make(),
                FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPage(\App\Filament\Pages\Backups::class)
                    ->usingPolingInterval('10s')
                    ->statusListRecordsTable(true)
                    ->timeout(300)
                    ->authorize(fn () => true), // Allow all authenticated users to access backups
                // Removed TomatoPHP FilamentUsers plugin to use our custom UserResource
            ])

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
            ->authMiddleware([Authenticate::class]);
    }
}
