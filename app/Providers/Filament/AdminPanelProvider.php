<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\LastLoggedInUsersDosenTendikWidget;
use App\Filament\Widgets\LastLoggedInUsersMahasiswaWidget;
use App\Filament\Widgets\LatestUsersDosenTendikWidget;
use App\Filament\Widgets\LatestUsersMahasiswaWidget;
use App\Filament\Widgets\UserStatsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
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
            ->brandName('TSU Homebase')
            ->favicon(asset('images/favicon/favicon.ico'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->userMenuItems([
                'logout' => MenuItem::make()
                    ->label('Log Out')
                    ->url(fn (): string => route('logout'))
                    ->icon('heroicon-o-arrow-left-on-rectangle'),
            ])
            ->colors([
                'primary' => Color::hex('#1A828F'), // <-- TSU Teal
                'secondary' => Color::hex('#F5B947'), // <-- TSU Mustard Gold
                'danger'  => Color::Red,
                'gray'    => Color::Slate, // <-- Kita pakai keluarga warna Slate untuk netral
                'info'    => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
//                AccountWidget::class,
//                FilamentInfoWidget::class,
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
                RoleMiddleware::class . ':admin|super admin',
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->sidebarCollapsibleOnDesktop();
    }
}
