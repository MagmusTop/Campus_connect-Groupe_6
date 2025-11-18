<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\AnnonceController; 


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/accueil', function () {
        return view('home');
    })->name('home');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/create', [ReservationController::class, 'create'])->name('create');
        Route::post('/', [ReservationController::class, 'store'])->name('store');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        Route::get('/{reservation}/edit', [ReservationController::class, 'edit'])->name('edit');
        Route::put('/{reservation}', [ReservationController::class, 'update'])->name('update');
        Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('salles')->name('salles.')->group(function () {
        Route::get('/', [SalleController::class, 'index'])->name('index');
        Route::get('/create', [SalleController::class, 'create'])->name('create');
        Route::get('/{salle}', [SalleController::class, 'show'])->name('show');
        Route::get('/{salle}/edit', [SalleController::class, 'edit'])->name('edit');
        Route::put('/{salle}', [SalleController::class, 'update'])->name('update');
        Route::post('/', [SalleController::class, 'store'])->name('store');
        Route::delete('/{salle}', [SalleController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('equipements')->name('equipements.')->group(function () {
        Route::get('/', [EquipementController::class, 'index'])->name('index');
        Route::post('/', [EquipementController::class, 'store'])->name('store');
        Route::get('/create', [EquipementController::class, 'create'])->name('create');
        Route::get('/{equipement}', [EquipementController::class, 'show'])->name('show');
        Route::get('/{equipement}/edit', [EquipementController::class, 'edit'])->name('edit');
        Route::put('/{equipement}', [EquipementController::class, 'update'])->name('update');
        Route::delete('/{equipement}', [EquipementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('annonces')->name('annonces.')->group(function () {
        Route::get('/', [AnnonceController::class, 'index'])->name('index');
        Route::post('/', [AnnonceController::class, 'store'])->name('store');
        Route::get('/create', [AnnonceController::class, 'create'])->name('create');
        Route::get('/{annonce}', [AnnonceController::class, 'show'])->name('show');
        Route::get('/{annonce}/edit', [AnnonceController::class, 'edit'])->name('edit');
        Route::put('/{annonce}', [AnnonceController::class, 'update'])->name('update');
        Route::delete('/{annonce}', [AnnonceController::class, 'destroy'])->name('destroy');
    });

});



require __DIR__.'/auth.php';
