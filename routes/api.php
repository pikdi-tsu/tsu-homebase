<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserDosenTendikController;
use App\Http\Controllers\Api\AuthController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/v1/client/users-dosen-tendik', [UserDosenTendikController::class, 'index'])
    ->middleware('client');
Route::get('/v1/user/users-dosen-tendik', [UserDosenTendikController::class, 'index'])
    ->middleware('auth:api');
Route::post('/login/dosen-tendik', [AuthController::class, 'loginDosenTendik']);
Route::post('/login/mahasiswa', [AuthController::class, 'loginMahasiswa']);
