<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GetUserPositionListController;
use App\Http\Controllers\GetRegistrationTokenController;

Route::get('/token', GetRegistrationTokenController::class);

Route::get('/positions', GetUserPositionListController::class);

Route::controller(UserController::class)->group(function () {
    Route::post('/users', 'store');
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show')->whereNumber('id');
});
