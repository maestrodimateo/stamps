<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/modules')
->middleware(['auth:sanctum', 'password_changed'])
->name('module.')->group(
    function () {
        Route::get('/', 'ModuleController')->name('list');
    }
);
