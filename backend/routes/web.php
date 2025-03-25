<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicationController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'index']);
Route::prefix('api')->group(function () {

Route::get('/registerAccount', [RegisterController::class, 'create'])->name('registerAccount');
Route::post('/registerAccount', [RegisterController::class, 'store'])->name('registerAccount');

Route::get('/loginAccount', [LoginController::class, 'create'])->name('loginAccount');
Route::post('/loginAccount', [LoginController::class, 'log_in'])->name('loginAccount');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/medications/{id}', [MedicationController::class, 'index'])->name('medications.index');
Route::post('/medications/{id}', [MedicationController::class, 'store'])->name('medications.store');
Route::get('/medications', [MedicationController::class, 'index'])->name('medications.index');
Route::post('/medications', [MedicationController::class, 'store'])->name('medications.store');
Route::delete('/medications/{id}', [MedicationController::class, 'destroy'])->name('medications.destroy');

Route::get('/appointments/{id}', [AppointmentController::class, 'index']);
Route::post('/appointments/{id}', [AppointmentController::class, 'store']);
Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);


});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';