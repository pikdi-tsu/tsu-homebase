<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HealthStatusPage;
use Spatie\Health\Models\HealthCheckResultHistoryItem;

Route::get('/', static fn() => redirect()->route('dashboard'));

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
