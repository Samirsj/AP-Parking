<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\AttenteController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Définition des routes de l'application.
|
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// 🏠 **Dashboard sécurisé (utilisateur connecté obligatoire)**
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard'); // ✅ Correction du nom
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

// 📌 **Routes nécessitant une authentification**
Route::middleware(['auth'])->group(function () {

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔒 **Gestion des utilisateurs (Admin uniquement)**
    Route::resource('admin', AdminController::class)
        ->middleware('can:viewAny,App\Models\User');

    // 🚗 **Gestion des places de parking (Admin uniquement)**
    Route::resource('parking', ParkingController::class)
        ->middleware('can:viewAny,App\Models\Parking');

    // ⏳ **Gestion de la liste d'attente**
    Route::resource('attente', AttenteController::class);
    Route::post('/attente/{id}/update-position', [AttenteController::class, 'updatePosition'])
        ->name('attente.updatePosition');

    // 🏷️ **Gestion de l'historique des attributions**
    Route::resource('historique', HistoriqueController::class);

    // 📅 **Gestion des réservations**
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
});

// 🔑 **Routes pour l'inscription**
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// 🔒 **Routes d'authentification (login, logout, reset password, etc.)**
require __DIR__.'/auth.php';
