<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name("login")->middleware('guest');
    Route::get('/register', [AuthController::class, 'createForm'])->name("register")->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/authenticate', [AuthController::class, 'login']);
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show');
    Route::post('/users', 'createUser');
    Route::delete('/users/{id}', 'deleteUser');
});



Route::controller(BusinessController::class)->group(function () {
    Route::prefix('businesses')->group(function () {
        Route::get('/create', 'create');
        Route::post('/store', 'createBusiness')->name('businesses.store');
    });
});
