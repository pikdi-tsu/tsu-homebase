<?php

namespace App\Providers;

use App\Listeners\CheckUserRoleAfterLogin;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            // Ganti 'admin' dengan nama role super admin Anda jika berbeda
            return $user->hasRole('super admin') ? true : null;
        });

        Passport::authorizationView('auth.oauth.authorize');
        Passport::enablePasswordGrant();
        Passport::tokensExpireIn(now()->addHours(8)); // Access Token berlaku 8 jam
        Passport::refreshTokensExpireIn(now()->addDays(30)); // Refresh Token berlaku 30 hari
        Passport::personalAccessTokensExpireIn(now()->addMonths(6)); // Token pribadi berlaku 6 bulan

        Event::listen(
            Login::class,
            CheckUserRoleAfterLogin::class
        );

        FilamentAsset::register([
            Js::make('custom-filament', __DIR__ . '/../../resources/js/custom-filament.js'),
        ]);
    }
}
