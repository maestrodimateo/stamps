<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'password_changed'])
->group(fn () => Route::apiResource('geographical-entities', GeoEntityController::class)
->parameters(['geographical-entities' => 'geographical_entities']));
