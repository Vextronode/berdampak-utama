<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/proyek/{slug}', [ProjectController::class, 'show'])->name('projects.show');
