<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Version 1
Route::post('v1/login', [\App\Http\Controllers\V1\UserController::class, 'login']);
Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {
    Route::get('logout', [\App\Http\Controllers\V1\UserController::class, 'logout']);
    // Users routes
    Route::resource('users', \App\Http\Controllers\V1\UserController::class)
        ->middleware('App\Http\Middleware\AdminMiddleware');
});
