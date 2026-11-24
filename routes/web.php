<?php

use App\Http\Controllers\Apanel\AuthController;
use App\Http\Controllers\Apanel\DashboardController;
use App\Http\Controllers\Apanel\FieldPostManagementController;
use App\Http\Controllers\Apanel\ProjectManagementController;
use App\Http\Controllers\Apanel\TechStackController;
use App\Http\Controllers\FieldPostController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/proyek/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/catatan', [FieldPostController::class, 'index'])->name('field-posts.index');
Route::get('/catatan/{slug}', [FieldPostController::class, 'show'])->name('field-posts.show');

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

        // Manajemen Proyek
        Route::get('/proyek/create', [ProjectManagementController::class, 'create'])->name('projects.create');
        Route::post('/proyek', [ProjectManagementController::class, 'store'])->name('projects.store');
        Route::get('/proyek/{project}/edit', [ProjectManagementController::class, 'edit'])->name('projects.edit');
        Route::put('/proyek/{project}', [ProjectManagementController::class, 'update'])->name('projects.update');
        Route::patch('/proyek/{project}/toggle-publish', [ProjectManagementController::class, 'togglePublish'])->name('projects.toggle-publish');
        Route::delete('/proyek/{project}', [ProjectManagementController::class, 'destroy'])->name('projects.destroy');

        // Manajemen Catatan Lapangan
        Route::get('/catatan', [FieldPostManagementController::class, 'index'])->name('field-posts.index');
        Route::get('/catatan/create', [FieldPostManagementController::class, 'create'])->name('field-posts.create');
        Route::post('/catatan', [FieldPostManagementController::class, 'store'])->name('field-posts.store');
        Route::get('/catatan/{fieldPost}/edit', [FieldPostManagementController::class, 'edit'])->name('field-posts.edit');
        Route::put('/catatan/{fieldPost}', [FieldPostManagementController::class, 'update'])->name('field-posts.update');
        Route::patch('/catatan/{fieldPost}/toggle-publish', [FieldPostManagementController::class, 'togglePublish'])->name('field-posts.toggle-publish');
        Route::delete('/catatan/{fieldPost}', [FieldPostManagementController::class, 'destroy'])->name('field-posts.destroy');

        // Dynamic Tech Stack API
        Route::post('/tech-stacks', [TechStackController::class, 'store'])->name('tech-stacks.store');
        Route::get('/tech-stacks/search', [TechStackController::class, 'search'])->name('tech-stacks.search');
    });
});

