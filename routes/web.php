<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\HoraireController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PropositionController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\RendezVousController;
use Illuminate\Support\Facades\Route;
// Accessible sans connexion (CU02, CU03)
Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::get('/offres', [OffreController::class, 'index'])->name('offres.index');
Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
// Visiteurs (CU01, CU04, CU05)
Route::middleware('guest')->group(function () {
    Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/inscription', [AuthController::class, 'register'])->name('register.store');
    Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion', [AuthController::class, 'login'])->name('login.store');
    Route::get('/mot-de-passe-oublie', [PasswordController::class, 'demande'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [PasswordController::class, 'envoyer'])->name('password.email');
    Route::get('/reinitialiser/{token}', [PasswordController::class, 'formulaire'])->name('password.reset');
    Route::post('/reinitialiser', [PasswordController::class, 'reinitialiser'])->name('password.update');
});
// Membres et administrateur connectés
Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/photo', [ProfilController::class, 'photo'])->name('profil.photo');
    Route::get('/abonnement', [AbonnementController::class, 'index'])->name('abonnement.index');
    Route::post('/abonnement', [AbonnementController::class, 'store'])->name('abonnement.store');
    Route::get('/demandes/nouvelle', [DemandeController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    Route::get('/recherche', [RechercheController::class, 'index'])->name('recherche');
    Route::post('/recherche/image', [RechercheController::class, 'image'])->name('recherche.image');
    Route::get('/membres/{membre}', [MembreController::class, 'show'])->name('membres.show');
    Route::post('/membres/{membre}/suivre', [MembreController::class, 'suivre'])->name('membres.suivre');
    Route::post('/membres/{membre}/rendez-vous', [RendezVousController::class, 'store'])->name('rdv.store');
    Route::get('/alertes', [AlerteController::class, 'index'])->name('alertes.index');
    Route::post('/offres/{offre}/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::get('/offres/{offre}', [OffreController::class, 'show'])->whereNumber('offre')->name('offres.show');
    // Abonnement obligatoire
    Route::middleware('abonne')->group(function () {
        Route::get('/offres/nouvelle', [OffreController::class, 'create'])->name('offres.create');
        Route::post('/offres', [OffreController::class, 'store'])->name('offres.store');
        Route::post('/demandes/{demande}/propositions', [PropositionController::class, 'store'])->name('propositions.store');
        Route::get('/horaires', [HoraireController::class, 'edit'])->name('horaires.edit');
        Route::post('/horaires', [HoraireController::class, 'update'])->name('horaires.update');
    });
});
// Panel administrateur (CU06, CU07, CU08)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/informations', [AdminController::class, 'information'])->name('information');
    Route::get('/acces', [AdminController::class, 'acces'])->name('acces');
    Route::post('/acces/{user}', [AdminController::class, 'basculer'])->name('basculer');
    Route::get('/statistiques', [AdminController::class, 'statistiques'])->name('statistiques');
});