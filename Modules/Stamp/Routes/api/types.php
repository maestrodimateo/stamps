<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'password_changed'])
->group(function () {
    Route::apiResource('types', TypeController::class)->whereUuid('type');
});
