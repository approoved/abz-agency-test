<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('user.index');
    Route::get('/users/create', 'create')->name('user.create');
});
