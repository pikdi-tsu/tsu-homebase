<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/admin/{any}', function () {
    // Skenario 1: Jika user belum login (guest)
    if (Auth::guest()) {
        return redirect()->route('login');
    }
    // Skenario 2: Jika user sudah login (tapi bukan admin)
//    return redirect()->route('dashboard');

})->where('any', '.*')->name('admin.fallback'); // Beri nama untuk jaga-jaga
