<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AuthController;

Route::prefix('/auth')->name('auth.')->group(
    function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
        Route::put('/edit/password', [AuthController::class, 'change_password'])->name('edit.password')
        ->middleware('auth:sanctum');
    }
);
