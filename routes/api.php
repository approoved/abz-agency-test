<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GetUserPositionListController;
use App\Http\Controllers\Api\GetRegistrationTokenController;

Route::get('/token', GetRegistrationTokenController::class);

Route::get('/positions', GetUserPositionListController::class);

Route::controller(UserController::class)->group(function () {
    Route::post('/users', 'store');
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show')->whereNumber('id');
});
