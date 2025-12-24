<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Livewire\HealthStatusPage;
use Spatie\Health\Models\HealthCheckResultHistoryItem;
use App\Http\Controllers\Auth\CustomPasswordResetLinkController;
use App\Http\Controllers\Auth\CustomNewPasswordController;
use App\Http\Controllers\Api\V1\SsoController;

Route::get('/', static fn() => redirect()->route('dashboard'));

// Authorization Grant Test Route
Route::get('/test-callback', static function (Request $request) {
    $code = $request->code ?? '';

    if (!$code) {
        return response()->json(['error' => 'Kode tidak ditemukan! Login gagal.'], 400);
    }

    $response = '';

    try {
        $response = \Illuminate\Support\Facades\Http::withoutVerifying()->asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('passport.authorization_grant_client.id'),
            'client_secret' => config('passport.authorization_grant_client.secret'),
            'redirect_uri' => config('app.url') . '/test-callback',
            'code' => $code,
        ]);
    } catch (\Illuminate\Http\Client\ConnectionException $e) {}

    return $response->json();
});

Route::get('/dashboard', function () {
    // 1. Dapatkan UUID dari batch pemeriksaan terakhir
    $latestBatch = HealthCheckResultHistoryItem::query()->latest()->value('batch');

    // 2. Dapatkan semua hasil pemeriksaan dari batch terakhir tersebut
    $latestChecks = HealthCheckResultHistoryItem::query()->where('batch', $latestBatch)->get();

    // 3. Cek apakah ada status yang 'failed' di dalam batch terakhir
    //    Tanda '!' di depan berarti "tidak ada yang failed"
    $isSystemOk = !$latestChecks->contains(fn ($check) => $check->status !== 'ok');

    return view('dashboard', ['isSystemOk' => $isSystemOk]);
})->name('dashboard');

//Route::get('/login', static function () {
//    return redirect()->route('login');
//})->name('login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //
});

Route::get('/logout', static function () {
    Auth::logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('/');
})->name('logout')->middleware('auth');

Route::get('/admin/{any}', static function () {
    // Skenario 1: Jika user belum login (guest)
    if (Auth::guest()) {
        return redirect()->route('login');
    }
    // Skenario 2: Jika user sudah login (tapi bukan admin)
    return redirect()->route('dashboard');

})->where('any', '.*')->name('admin.fallback'); // Beri nama untuk jaga-jaga

Route::get('/status-sistem', HealthStatusPage::class)
    ->middleware('auth')
    ->name('health.status');

Route::post('/forgot-password', [CustomPasswordResetLinkController::class, 'store'])
    ->middleware(['guest'])->name('password.email');

Route::post('/reset-password', [CustomNewPasswordController::class, 'store'])
    ->middleware(['guest'])->name('password.update');

// --- Rute untuk Testing Halaman Error ---
//Route::get('/404', function () {
//    abort(404);
//})->name('404');
//
//Route::get('/403', function () {
//    abort(403, 'Akses Ditolak.');
//})->name('403');
//
//Route::get('/500', function () {
//    abort(500, 'Terjadi Masalah Internal.');
//})->name('500');
