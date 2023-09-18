<?php

use Illuminate\Support\Facades\Route;
use Modules\Stamp\Http\Controllers\StampController;


Route::middleware(['auth:sanctum', 'password_changed'])
->group(function () {

    Route::get('stamps/verify/{stamp}', [StampController::class, 'verify'])
    ->withoutMiddleware(['auth:sanctum', 'password_changed'])
    ->whereUuid('stamp')
    ->name('stamp.verify');

    Route::apiResource('stamps', \StampController::class)->whereUuid('stamp');
});
