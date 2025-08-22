<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserDosenTendikController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users-dosen-tendik', [UserDosenTendikController::class, 'index'])->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
