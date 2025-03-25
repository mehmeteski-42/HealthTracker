<?php
// routes/api.php
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicationController;
use Illuminate\Support\Facades\Route;

// API rotaları
Route::post('/registerAccount', [RegisterController::class, 'store'])->name('registerAccount');
Route::post('/loginAccount', [LoginController::class, 'log_in'])->name('loginAccount');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/appointments/{id}', [AppointmentController::class, 'index']);
Route::post('/appointments/{id}', [AppointmentController::class, 'store']);
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);

    Route::post('/medications', [MedicationController::class, 'store']);
    Route::delete('/medications/{id}', [MedicationController::class, 'destroy']);
});