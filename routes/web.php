<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Routes de gestion réservées aux Professeurs et Admins (CREATE doit être avant le wildcard {etudiant})
    Route::middleware(['staff'])->group(function () {
        Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
        Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
    });

    // Routes consultables par tous les utilisateurs connectés
    Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
    Route::get('/etudiants/{etudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');

    // Autres routes de gestion réservées aux Professeurs et Admins
    Route::middleware(['staff'])->group(function () {
        Route::get('/etudiants/{etudiant}/edit', [EtudiantController::class, 'edit'])->name('etudiants.edit');
        Route::put('/etudiants/{etudiant}', [EtudiantController::class, 'update'])->name('etudiants.update');
        Route::delete('/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');

        // Gestion des notes
        Route::get('/etudiants/{etudiant}/notes/create', [NoteController::class, 'create'])->name('notes.create');
        Route::post('/etudiants/{etudiant}/notes', [NoteController::class, 'store'])->name('notes.store');
    });

    // Routes pour la gestion des utilisateurs par l'admin
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/create-professor', [AdminController::class, 'createProfessor'])->name('create-professor');
        Route::post('/create-professor', [AdminController::class, 'storeProfessor'])->name('store-professor');
        Route::get('/create-student', [AdminController::class, 'createStudent'])->name('create-student');
        Route::post('/create-student', [AdminController::class, 'storeStudent'])->name('store-student');
        Route::get('/users-list', [AdminController::class, 'usersList'])->name('users-list');
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
