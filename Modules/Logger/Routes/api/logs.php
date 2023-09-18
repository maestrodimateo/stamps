<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/logs')
->middleware(['auth:sanctum', 'password_changed'])
->name('log.')->group(
    function () {
        Route::get('/', 'LoggerController')->name('list');
    }
);
