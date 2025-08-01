<?php

use App\Http\Controllers\Site\LoginController;
use Illuminate\Support\Facades\Route;

if (\App\Helpers\SectionHelper::is('admin')) {
    include_once __DIR__ . '/admin.php';
} else {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login/otp', [LoginController::class, 'sendOtp'])->name('login.send-otp');
        Route::post('login/verity', [LoginController::class, 'verity'])->name('login.verity');
    });
}

