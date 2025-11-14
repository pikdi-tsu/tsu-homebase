<?php

namespace App\Providers;

use App\Health\IndonesianWindowsDiskSpaceCheck;
use App\Http\Responses\LoginResponse;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Listeners\CheckUserRoleAfterLogin;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(static function ($user, $ability) {
            // Ganti 'admin' dengan nama role super admin Anda jika berbeda
            return $user->hasRole('super admin') ? true : null;
        });

        Passport::authorizationView('auth.oauth.authorize');
        Passport::enablePasswordGrant();
        Passport::tokensExpireIn(now()->addHours(8)); // Access Token berlaku 8 jam
        Passport::refreshTokensExpireIn(now()->addDays(30)); // Refresh Token berlaku 30 hari
        Passport::personalAccessTokensExpireIn(now()->addMonths(6)); // Token pribadi berlaku 6 bulan

        // Cek dulu apakah tabelnya ada, untuk mencegah error saat migrasi
        if (Schema::hasTable('permissions')) {
            $permissions = Permission::all()->pluck('name')->toArray();
            $scopes = array_fill_keys($permissions, 'Izin dinamis dari database');
            Passport::tokensCan($scopes);
        }

        Event::listen(
            Login::class,
            CheckUserRoleAfterLogin::class
        );

        FilamentAsset::register([
            Js::make('custom-filament', __DIR__ . '/../../resources/js/custom-filament.js'),
        ]);

        Health::checks([
            ScheduleCheck::new(),
            DatabaseCheck::new(),
            CacheCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
//            UsedDiskSpaceCheck::new(),
            IndonesianWindowsDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(60)
                ->failWhenUsedSpaceIsAbovePercentage(85),
        ]);

        View::composer('navigation-menu', function ($view) {
            $view->with('navItems', app(GeneralSettings::class)->main_navigation);
        });
    }
}
