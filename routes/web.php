<?php

/* Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
}); */


use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/registerAccount', [RegisterController::class, 'create'])->name('registerAccount');
Route::post('/registerAccount', [RegisterController::class, 'store'])->name('registerAccount');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
