<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Filament\Notifications\Notification;
use League\OAuth2\Server\Exception\OAuthServerException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies('*');
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'scopes' => \Laravel\Passport\Http\Middleware\CheckTokenForAnyScope::class,
            'scope' => \Laravel\Passport\Http\Middleware\CheckToken::class,
            'client' => \Laravel\Passport\Http\Middleware\EnsureClientIsResourceOwner::class,
        ]);
        $middleware->appendToGroup('api', [
            \App\Http\Middleware\CheckUserIsActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handler untuk Database Down (QueryException)
        $exceptions->renderable(function (\Illuminate\Database\QueryException $e, $request) {
            return response()->view('errors.503', [], 503);
        });

        // Handler untuk Akses Ditolak (403 Forbidden)
        $exceptions->renderable(function (HttpException $e, $request) {
            // Cek apakah status kodenya adalah 403 (Forbidden)
            // Cek apakah user sudah login DAN sedang mencoba akses panel admin
            if (($e->getStatusCode() === 403) && Auth::check() && $request->is('admin/*')) {
                // Jika ini adalah request halaman biasa (bukan aksi dari tombol/AJAX)
                if (!$request->ajax() && !$request->header('X-Livewire')) {
                    // Alihkan ke dashboard Jetstream
                    return redirect()->route('dashboard');
                }
                // Untuk request aksi (AJAX/Livewire), tetap tampilkan TOAST
                Notification::make()
                    ->title('Aksi Ditolak')
                    ->body('Anda tidak memiliki hak akses yang diperlukan.')
                    ->danger()
                    ->send();

                return redirect()->back();
            }
            return null;
        });

        $exceptions->render(function (LogicException $e, Request $request) {

            // Cek pesan errornya spesifik soal Key
            if (str_contains($e->getMessage(), 'Invalid key supplied')) {
                // Return tampilan cantik, atau redirect ke halaman error custom
                return response()->view('errors.500', [], 500);
            }

            // Biarkan error lain lewat (atau handle juga)
            return null;
        });
    })->create();
