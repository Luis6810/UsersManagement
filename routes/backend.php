<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(UserController::class)->group(function(){
    Route::get('users', 'index');
    Route::post('user', 'store');
    Route::get('user/{id}', 'show');
    Route::put('user/{id}', 'update');
    Route::delete('user/{id}', 'destroy');
});
