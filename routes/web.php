<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\AttenteController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;

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

//  **Dashboard sécurisé (utilisateur connecté obligatoire)**
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard'); //  Correction du nom
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

//  **Routes nécessitant une authentification**
Route::middleware(['auth'])->group(function () {
    // Routes pour les utilisateurs
    Route::resource('users', UserController::class);
    
    // Routes pour le parking
    Route::resource('parking', ParkingController::class);
    
    // Routes pour les réservations
    Route::resource('reservations', ReservationController::class);
    
    // Routes pour l'historique
    Route::resource('historiques', HistoriqueController::class);
    
    // Routes pour l'attente
    Route::resource('attente', AttenteController::class);

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // **Gestion des utilisateurs (Admin uniquement)**
    Route::resource('admin', AdminController::class)
        ->middleware('can:viewAny,App\Models\User');

    // **Gestion des places de parking (Admin uniquement)**
    Route::post('/parking/{parking}/occuper', [ParkingController::class, 'marquerOccupee'])->name('parking.occuper');
    Route::post('/parking/{parking}/liberer', [ParkingController::class, 'marquerLibre'])->name('parking.liberer');
    Route::post('/admin/attribuer-place', [AdminController::class, 'attribuerPlaceAutomatiquement'])->name('admin.attribuer-place');

    // **Gestion de la liste d'attente**
    Route::post('/attente/{id}/update-position', [AttenteController::class, 'updatePosition'])
        ->name('attente.updatePosition');

    // **Gestion de l'historique des attributions**
    Route::resource('historique', HistoriqueController::class);

    // **Gestion des réservations**
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::post('/reservation/cancel', [ReservationController::class, 'cancel'])->name('reservation.cancel');
});

// **Routes pour l'inscription**
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
// **Routes d'authentification (login, logout, reset password, etc.)**
require __DIR__.'/auth.php';
