<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EquipementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('salles')->groupe(function () {
    Route::get('/', [SalleController::class, 'index'])->name('salles.index');
    Route::get('/create', [SalleController::class, 'create'])->name('salles.create');
    Route::post('/', [SalleController::class, 'store'])->name('salles.store');
    Route::get('/{salle}', [SalleController::class, 'show'])->name('salles.show');
    Route::get('/{salle}/edit', [SalleController::class, 'edit'])->name('salles.edit');
    Route::put('/{salle}', [SalleController::class, 'update'])->name('salles.update');
    Route::delete('/{salle}', [SalleController::class, 'destroy'])->name('salles.destroy');
});



require __DIR__.'/auth.php';
