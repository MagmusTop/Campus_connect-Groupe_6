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
use App\Http\Controllers\AnnonceController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

Route::prefix('salles')->group(function () {
    Route::get('/', [SalleController::class, 'index'])->name('salles.index');
    Route::get('/{salle}', [SalleController::class, 'show'])->name('salles.show');
    Route::get('/create', [SalleController::class, 'create'])->name('salles.create');
    Route::get('/{salle}/edit', [SalleController::class, 'edit'])->name('salles.edit');
    Route::post('/', [SalleController::class, 'store'])->name('salles.store');
    Route::put('/{salle}', [SalleController::class, 'update'])->name('salles.update');
    Route::delete('/{salle}', [SalleController::class, 'destroy'])->name('salles.destroy');
});

Route::prefix('reservations')->group(function () {
    Route::get('/', [CategorieController::class, 'index'])->name('reservations.index');
    Route::get('/{reservation}', [CategorieController::class, 'show'])->name('reservations.show');
    Route::get('/create', [CategorieController::class, 'create'])->name('reservations.create');
    Route::get('/{reservation}/edit', [CategorieController::class, 'edit'])->name('reservations.edit');
    Route::post('/', [CategorieController::class, 'store'])->name('reservations.store');
    Route::put('/{reservation}', [CategorieController::class, 'update'])->name('reservations.update');
    Route::delete('/{reservation}', [CategorieController::class, 'destroy'])->name('reservations.destroy');
});

Route::prefix('equipements')->group(function () {
    Route::get('/', [EquipementController::class, 'index'])->name('equipements.index');
    Route::get('/{equipement}', [EquipementController::class, 'show'])->name('equipements.show');
    Route::get('/create', [EquipementController::class, 'create'])->name('equipements.create');
    Route::get('/{equipement}/edit', [EquipementController::class, 'edit'])->name('equipements.edit');
    Route::post('/', [EquipementController::class, 'store'])->name('equipements.store');
    Route::put('/{equipement}', [EquipementController::class, 'update'])->name('equipements.update');
    Route::delete('/{equipement}', [EquipementController::class, 'destroy'])->name('equipements.destroy');
});

Route::prefix('annonces')->group(function () {
    Route::get('/', [AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');
    Route::get('/create', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::get('/{annonce}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::post('/', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::put('/{annonce}', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::delete('/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');
});


require __DIR__.'/auth.php';
