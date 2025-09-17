<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', static function () {
//    return view('welcome');
//});

Route::get('/', static fn() => redirect()->route('dashboard'));
//Route::get('/', static function () {
//    return view('dashboard');
//});

Route::get('/dashboard', static function () {
    return view('dashboard');
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
