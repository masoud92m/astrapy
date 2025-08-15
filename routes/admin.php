<?php

use App\Http\Controllers\Admin\PackageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\LoginController;

Route::prefix('admin')->name('admin.')->middleware([
    'auth',
    \App\Http\Middleware\IsAdmin::class,
    \App\Http\Middleware\UserAuthorization::class,
])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('logout', [\App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('logout');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('get-analysis', [PackageController::class, 'getAnalysis'])->name('get-analysis');
});
