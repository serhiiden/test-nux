<?php

use App\Http\Controllers\PageAController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'create'])->name('home');
Route::post('/register', [RegistrationController::class, 'store'])->name('register');

Route::get('/a/{token}', [PageAController::class, 'show'])->name('page-a.show');
Route::post('/a/{token}/regenerate', [PageAController::class, 'regenerate'])->name('page-a.regenerate');
Route::post('/a/{token}/deactivate', [PageAController::class, 'deactivate'])->name('page-a.deactivate');
