<?php

use App\Http\Controllers\GetRegistrationTokenController;
use Illuminate\Support\Facades\Route;

Route::get('/token', GetRegistrationTokenController::class);
