<?php

use App\Http\Controllers\Admin\PodcastItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\LoginController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login/otp', [LoginController::class, 'sendOtp'])->name('login.send-otp');
        Route::post('login/verity', [LoginController::class, 'verity'])->name('login.verity');
    });
    Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('logout', [\App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('logout');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
});
