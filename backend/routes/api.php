<?php
// routes/api.php
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicationController;
use Illuminate\Support\Facades\Route;

// API rotaları '/api' prefix'i ile başlayacak


Route::post('/registerAccount', [RegisterController::class, 'store'])->name('registerAccount');
Route::post('/loginAccount', [LoginController::class, 'log_in'])->name('loginAccount');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointments.store');
Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

Route::post('/medications', [MedicationController::class, 'store'])->name('medications.store');
Route::delete('/medications/{id}', [MedicationController::class, 'destroy'])->name('medications.destroy');
