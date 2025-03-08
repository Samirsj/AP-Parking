<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\AttenteController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes accessibles à l'application.
|
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Dashboard sécurisé (nécessite une authentification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestion des utilisateurs (Admin uniquement)
    Route::resource('admin', AdminController::class)
        ->middleware('can:viewAny,App\Models\User');

    // Gestion des places de parking (Admin uniquement)
    Route::resource('parking', ParkingController::class)
        ->middleware('can:viewAny,App\Models\Parking');

    // Gestion de la liste d'attente
    Route::resource('attente', AttenteController::class);

    // Gestion de l'historique des attributions
    Route::resource('historique', HistoriqueController::class);
});

// Routes pour l'inscription
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Inclusion des routes d'authentification (login, logout, reset password, etc.)
require __DIR__.'/auth.php';
