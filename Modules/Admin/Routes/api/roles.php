<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\RoleController;

Route::prefix('/roles')
->name('role.')
->middleware(['auth:sanctum', 'password_changed'])
->group(
    function () {
        Route::get('/', [RoleController::class, 'list'])->name('list');
        Route::post('/', [RoleController::class, 'create'])->name('create');
        Route::get('{role}', [RoleController::class, 'show'])->whereUuid('role')->name('show');
        Route::put('{role}', [RoleController::class, 'update'])->whereUuid('role')->name('update');
        Route::delete('{role}', [RoleController::class, 'delete'])->whereUuid('role')->name('delete');
    }
);
