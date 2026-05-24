<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Item routes
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items/{item}', [ItemController::class, 'show']);
    Route::put('/items/{item}', [ItemController::class, 'update']);
    Route::delete('/items/{item}', [ItemController::class, 'destroy']);

    // Group routes - viewable by all authenticated users
    Route::get('/groups', [GroupController::class, 'index']);
    Route::get('/groups/{group}', [GroupController::class, 'show']);

    // Group routes - admin only
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::post('/groups', [GroupController::class, 'store']);
        Route::post('/groups/{group}/users', [GroupController::class, 'addUser']);
        Route::delete('/groups/{group}/users', [GroupController::class, 'removeUser']);
    });

    // Log routes
    Route::get('/logs', [LogController::class, 'index']);
    Route::post('/logs', [LogController::class, 'store']);
    Route::get('/logs/{log}', [LogController::class, 'show']);

    // Settings routes
    Route::get('/settings', [UserSettingController::class, 'show']);
    Route::post('/settings', [UserSettingController::class, 'store']);
    Route::put('/settings', [UserSettingController::class, 'update']);
});