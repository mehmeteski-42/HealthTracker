<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicationController;
use Illuminate\Support\Facades\Route;


Route::prefix('api')->group(function () {
Route::get('/', [WelcomeController::class, 'index']);

Route::get('/registerAccount', [RegisterController::class, 'create'])->name('registerAccount');
Route::post('/registerAccount', [RegisterController::class, 'store'])->name('registerAccount');

Route::get('/loginAccount', [LoginController::class, 'create'])->name('loginAccount');
Route::post('/loginAccount', [LoginController::class, 'log_in'])->name('loginAccount');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointments.store');
Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

Route::post('/medications', [MedicationController::class, 'store'])->name('medications.store');
Route::delete('/medications/{id}', [MedicationController::class, 'destroy'])->name('medications.destroy');

});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
