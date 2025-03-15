<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;

Route::get('/', [CardController::class, 'index'])->name('home');


Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'showRegist'])->name('register');
    Route::post('/register/store', [UserController::class, 'register'])->name('register.store');
    
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login/auth', [UserController::class, 'login'])->name('login.auth');
});

Route::get('/cards/manage', [CardController::class, 'manage'])->name('cards.manage');

Route::middleware('auth')->group(function () {
    Route::get('/cards/create', [CardController::class, 'create']);
    Route::post('/cards/store', [CardController::class, 'store'])->name('cards.store');
    Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
    Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::get('/cards/{card}', [CardController::class, 'show']);


