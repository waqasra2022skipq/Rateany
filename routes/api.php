<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show');
    Route::post('/users', 'createUser');
    Route::delete('/users/{id}', 'deleteUser');
});


Route::controller(BusinessController::class)->group(function () {
    Route::get('/businesses', 'index');
    Route::get('/businesses/{id}', 'show');
    Route::post('/businesses', 'createBusiness');
    Route::delete('/businesses/{id}', 'deleteBusiness');
});
