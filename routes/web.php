<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserQueryController;
use App\Livewire\Businesses\BusinessesList;
use App\Livewire\Businesses\Categories;
use App\Livewire\Home;
use App\Livewire\Profile\Profile;
use App\Livewire\Businesses\CategoryPage;
use App\Livewire\Professionals\ProfessionPage;
use App\Livewire\Professionals\Professions;

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name("login")->middleware('guest');
    Route::get('/register', [AuthController::class, 'createForm'])->name("register")->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/authenticate', [AuthController::class, 'login']);
});

Route::controller(UserController::class)->group(function () {
    Route::get('/professionals', 'index')->name('allUsers');
    Route::get('/profile/{id}/edit', 'edit')->name("profile.edit")->middleware('auth');
    Route::get('/profile/{slug}', 'profile')->name("profile.show")->middleware('auth');
    Route::put('/profile/{id}', 'updateUser')->name("users.update")->middleware('auth');
    Route::put('/profile/update-image', 'updateProfileImage')->name("profile.updateImage")->middleware('auth');
    Route::get('/professionals/{slug}', 'show')->name('user.show');
    Route::post('/users', 'createUser');
    Route::delete('/users/{id}', 'deleteUser');

    Route::get('/users/{id}/write-review', 'reviewForm')->name('user.write-review');
});


Route::controller(BusinessController::class)->group(function () {
    Route::prefix('businesses')->group(function () {
        // Route::get('/', 'allBusinesses')->name('allBusinesses');
        Route::get('/manage', 'myBusinesses')->name('businesses.manage');
        Route::get('/create', 'create')->name('businesses.create');
        Route::post('/store', 'createBusiness')->name('businesses.store');
        Route::get('/{id}/edit', 'edit')->name('businesses.edit');
        Route::get('/{id}', 'show')->name('businesses.show');
        Route::put('/{id}', 'updateBusiness')->name('businesses.update');
        Route::delete('/{id}', 'destroy')->name('businesses.destroy');

        Route::get('/{id}/write-review', 'reviewForm')->name('businesses.write-review');
    });
});

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


Route::get('/contact-us', [UserQueryController::class, 'show'])->name('contact.show');

Route::get('/contacts', [UserQueryController::class, 'index'])->name('contacts.index');
Route::post('/contact-us', [UserQueryController::class, 'store'])->name('user_queries.store');

// Livewire updates

Route::get('/', Home::class)->name('home');
Route::get('/home', Home::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', Profile::class)->name('profile.profile');
});
Route::prefix('/categories')->group(function () {
    Route::get('/', Categories::class)->name('categories');
    Route::get('/{slug}', CategoryPage::class)->name('categoryPage');
});

Route::prefix('/professions')->group(function () {
    Route::get('/', Professions::class)->name('professions');
    Route::get('/{slug}', ProfessionPage::class)->name('professionPage');
});

Route::prefix('businesses')->group(function () {
    Route::get('/', BusinessesList::class)->name('allBusinesses');
});
