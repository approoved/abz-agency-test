<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetUserPositionListController;
use App\Http\Controllers\GetRegistrationTokenController;

Route::get('/token', GetRegistrationTokenController::class);

Route::get('/positions', GetUserPositionListController::class);
