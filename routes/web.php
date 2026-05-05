<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AuthController;

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Route Resource pour la gestion des étudiants
    Route::resource('etudiants', EtudiantController::class);

    // Routes pour la gestion des notes
    Route::get('/etudiants/{etudiant}/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/etudiants/{etudiant}/notes', [NoteController::class, 'store'])->name('notes.store');

    // Groupes de Routes pour l'administration (existant)
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return "Bienvenue sur le tableau de bord administrateur";
        });
        Route::get('/settings', function () {
            return "Paramètres de l'administration";
        });
    });
});

// Routes publiques
Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return "Bonjour tout le monde !";
});

Route::get('/about', function () {
    return view('about');
});
