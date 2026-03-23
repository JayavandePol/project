<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    // Phase 1: Overzichten
    Route::get('/klanten', [App\Http\Controllers\KlantController::class, 'index'])->name('klanten.index');
    Route::get('/reizen', [App\Http\Controllers\ReisController::class, 'index'])->name('reizen.index');
    Route::get('/accommodaties', [App\Http\Controllers\AccommodatieController::class, 'index'])->name('accommodaties.index');
    Route::get('/boekingen', [App\Http\Controllers\BoekingController::class, 'index'])->name('boekingen.index');
    Route::get('/facturen', [App\Http\Controllers\FactuurController::class, 'index'])->name('facturen.index');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\AdminUserController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
});
