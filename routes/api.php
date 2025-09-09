<?php

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('sanctum/csrf-cookie', fn() => response()->json(['message' => 'CSRF cookie set']));

Route::name('user')
    ->prefix('user')
    ->group(function() {
        // Guest routes
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

        // Authenticated routes
        Route::middleware('auth:sanctum')->group(function() {
            Route::get('get-auth', [UserController::class, 'getAuthUser'])->name('get-auth');
        });
    });