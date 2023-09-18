<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\DocumentController;

Route::prefix('/documents')
->name('document.')
->middleware(['auth:sanctum', 'password_changed'])
->group(
    function () {
        Route::get('/', [DocumentController::class, 'list'])->name('list');
        Route::post('/', [DocumentController::class, 'create'])->name('create');
        Route::get('{document}', [DocumentController::class, 'show'])->whereUuid('document')->name('show');
        Route::delete('{document}', [DocumentController::class, 'delete'])->whereUuid('document')->name('delete');
    }
);
