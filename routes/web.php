<?php

use App\Http\Controllers\Apanel\AuthController;
use App\Http\Controllers\Apanel\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/proyek/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::middleware('prevent.back')->group(function () {
    Route::get('/apanel', function () {
        return Auth::check()
            ? redirect()->route('apanel.dashboard')
            : redirect()->route('apanel.login');
    })->name('apanel.index');

    Route::middleware('guest')->prefix('apanel')->name('apanel.')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth')->prefix('apanel')->name('apanel.')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});

