<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\LastLoggedInUsersDosenTendikWidget;
use App\Filament\Widgets\LastLoggedInUsersMahasiswaWidget;
use App\Filament\Widgets\LatestUsersDosenTendikWidget;
use App\Filament\Widgets\LatestUsersMahasiswaWidget;
use App\Filament\Widgets\UserStatsOverview;
use Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
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
use Spatie\Permission\Middleware\RoleMiddleware;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->userMenuItems([
                'logout' => MenuItem::make()
                    ->label('Log Out')
                    ->url(fn (): string => route('logout'))
                    ->icon('heroicon-o-arrow-left-on-rectangle'),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->favicon('images/icon-logo-tsu.png')
            ->brandName('TSU Homebase')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
//                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
                UserStatsOverview::class,
                LatestUsersDosenTendikWidget::class,
                LatestUsersMahasiswaWidget::class,
                LastLoggedInUsersDosenTendikWidget::class,
                LastLoggedInUsersMahasiswaWidget::class,
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
                RoleMiddleware::class . ':admin|super-admin',
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->sidebarCollapsibleOnDesktop();
    }
}
