<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Phase 1, 2 & 3: Overzichten, Toevoegen & Bewerken
    Route::get('/klanten', [App\Http\Controllers\KlantController::class, 'index'])->name('klanten.index');
    Route::get('/klanten/create', [App\Http\Controllers\KlantController::class, 'create'])->name('klanten.create');
    Route::post('/klanten', [App\Http\Controllers\KlantController::class, 'store'])->name('klanten.store');
    Route::get('/klanten/{id}/edit', [App\Http\Controllers\KlantController::class, 'edit'])->name('klanten.edit');
    Route::put('/klanten/{id}', [App\Http\Controllers\KlantController::class, 'update'])->name('klanten.update');
    Route::delete('/klanten/{id}', [App\Http\Controllers\KlantController::class, 'destroy'])->name('klanten.destroy');

    Route::get('/reizen', [App\Http\Controllers\ReisController::class, 'index'])->name('reizen.index');
    Route::get('/reizen/create', [App\Http\Controllers\ReisController::class, 'create'])->name('reizen.create');
    Route::post('/reizen', [App\Http\Controllers\ReisController::class, 'store'])->name('reizen.store');
    Route::get('/reizen/{id}/edit', [App\Http\Controllers\ReisController::class, 'edit'])->name('reizen.edit');
    Route::put('/reizen/{id}', [App\Http\Controllers\ReisController::class, 'update'])->name('reizen.update');
    Route::delete('/reizen/{id}', [App\Http\Controllers\ReisController::class, 'destroy'])->name('reizen.destroy');

    Route::get('/accommodaties', [App\Http\Controllers\AccommodatieController::class, 'index'])->name('accommodaties.index');
    Route::get('/accommodaties/create', [App\Http\Controllers\AccommodatieController::class, 'create'])->name('accommodaties.create');
    Route::post('/accommodaties', [App\Http\Controllers\AccommodatieController::class, 'store'])->name('accommodaties.store');
    Route::get('/accommodaties/{id}/edit', [App\Http\Controllers\AccommodatieController::class, 'edit'])->name('accommodaties.edit');
    Route::put('/accommodaties/{id}', [App\Http\Controllers\AccommodatieController::class, 'update'])->name('accommodaties.update');
    Route::delete('/accommodaties/{id}', [App\Http\Controllers\AccommodatieController::class, 'destroy'])->name('accommodaties.destroy');

    Route::get('/boekingen', [App\Http\Controllers\BoekingController::class, 'index'])->name('boekingen.index');
    Route::get('/boekingen/create', [App\Http\Controllers\BoekingController::class, 'create'])->name('boekingen.create');
    Route::post('/boekingen', [App\Http\Controllers\BoekingController::class, 'store'])->name('boekingen.store');
    Route::get('/boekingen/{id}/edit', [App\Http\Controllers\BoekingController::class, 'edit'])->name('boekingen.edit');
    Route::put('/boekingen/{id}', [App\Http\Controllers\BoekingController::class, 'update'])->name('boekingen.update');
    Route::delete('/boekingen/{id}', [App\Http\Controllers\BoekingController::class, 'destroy'])->name('boekingen.destroy');

    Route::get('/facturen', [App\Http\Controllers\FactuurController::class, 'index'])->name('facturen.index');
    Route::patch('/facturen/{id}/status', [App\Http\Controllers\FactuurController::class, 'updateStatus'])->name('facturen.updateStatus');
    Route::delete('/facturen/{id}', [App\Http\Controllers\FactuurController::class, 'destroy'])->name('facturen.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\AdminUserController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('/users/{id}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});
