<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'create'])->name('home');
Route::post('/register', [RegistrationController::class, 'store'])->name('register');

Route::get('/a/{token}', fn (string $token) => 'Page A: coming soon')->name('page-a.show');
