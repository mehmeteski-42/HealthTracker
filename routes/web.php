<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

use App\Http\Controllers\WelcomeController;
Route::get('/', [WelcomeController::class, 'index']);


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
