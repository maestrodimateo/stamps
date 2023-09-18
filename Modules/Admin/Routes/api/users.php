<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\UserController;

Route::prefix('/users')
->name('user.')
->middleware(['auth:sanctum', 'password_changed'])
->group(
    function () {
        Route::get('/', [UserController::class, 'list'])->name('list');
        Route::post('/', [UserController::class, 'create'])->name('create');
        Route::put('restore/{other_users}', [UserController::class, 'restore'])
        ->withTrashed()->whereUuid('user')->name('restore');
        Route::get('{user}', [UserController::class, 'show'])->whereUuid('user')->name('show');
        Route::put('{user}', [UserController::class, 'update'])->whereUuid('user')->name('update');
        Route::delete('destroy/{other_users}', [UserController::class, 'destroy'])->whereUuid('other_users')
        ->withTrashed()->name('destroy');
        Route::delete('{other_users}', [UserController::class, 'delete'])->whereUuid('other_users')
        ->name('delete');
    }
);
