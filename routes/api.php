<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserDosenTendikController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\UserProfileController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\AuthorizationController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

//Route::get('/v1/client/users-dosen-tendik', [UserDosenTendikController::class, 'index'])
//    ->middleware('client');
//Route::get('/v1/user/users-dosen-tendik', [UserDosenTendikController::class, 'index'])
//    ->middleware('auth:api');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Endpoints Otentikasi (Publik) ---
Route::prefix('v1/auth')->group(function () {
    Route::post('/login/dosen-tendik', [AuthController::class, 'loginDosenTendik']);
    Route::post('/login/mahasiswa', [AuthController::class, 'loginMahasiswa']);

    // Endpoint logout harus dilindungi otentikasi
    Route::middleware('auth:api,api2')->post('/logout', [AuthController::class, 'logout']);
});


// --- Endpoints Profil (Untuk User yang Sudah Login) ---
Route::middleware('auth:api,api2')->prefix('v1')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::put('/profile', [UserProfileController::class, 'update']);
    Route::post('/profile/change-password', [UserProfileController::class, 'changePassword']);
});


// --- Endpoints Manajemen User (Untuk Antar Server/Modul) ---
Route::middleware(['client', 'scopes:homebase:user-dosen-tendik:view-any,homebase:user-mahasiswa:view-any'])->prefix('v1')->group(function () {
    // Anda bisa menambahkan 'scope:permission' di sini jika semua butuh permission yg sama
    Route::apiResource('users', UserController::class);

    // --- Endpoints Manajemen Role dan Permission (Untuk Antar Server/Modul) ---
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);

    // Endpoint otorisasi
    Route::get('/users/{id}/permissions', [AuthorizationController::class, 'getUserPermissions']);
});
