<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BusinessController::class, 'index']);


Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name("login")->middleware('guest');
    Route::get('/register', [AuthController::class, 'createForm'])->name("register")->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/authenticate', [AuthController::class, 'login']);
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/profile/{id}/edit', 'edit')->name("profile.edit")->middleware('auth');
    Route::get('/profile/{id}', 'show')->name("profile.show")->middleware('auth');
    Route::put('/profile/{id}', 'updateUser')->name("users.update")->middleware('auth');
    Route::put('/profile/update-image', 'updateProfileImage')->name("profile.updateImage")->middleware('auth');
    Route::get('/users/{id}', 'show');
    Route::post('/users', 'createUser');
    Route::delete('/users/{id}', 'deleteUser');
});



Route::controller(BusinessController::class)->group(function () {
    Route::prefix('businesses')->group(function () {
        Route::get('/manage', 'index');
        Route::get('/create', 'create')->name('businesses.create');
        Route::post('/store', 'createBusiness')->name('businesses.store');
        Route::get('/{id}', 'edit')->name('businesses.edit');
        Route::put('/{id}', 'updateBusiness')->name('businesses.update');
        Route::delete('/{id}', 'destroy')->name('businesses.destroy');

        Route::get('/{id}/write-review', 'reviewForm')->name('businesses.write-review');
    });
});

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
