<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\MessageDiffusionController;
use Illuminate\Support\Facades\Route;

// Accueil
Route::get('/', [HomeController::class, 'index'])->name('front.accueil');

// Articles
Route::get('/articles', [HomeController::class, 'tousLesArticles'])->name('front.articles');

// Contact
Route::get('/contact', [ContactController::class, 'showForm'])->name('front.contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('front.contact.submit');

// Routes publiques panier (client)
Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::get('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::get('/panier/vider', [PanierController::class, 'vider'])->name('panier.vider');
Route::get('/panier/valider', [PanierController::class, 'afficherFormulaireCommande'])->name('panier.valider.form');
Route::post('/panier/valider', [PanierController::class, 'valider'])->name('panier.valider.post');
Route::put('/panier/{id}/modifier', [PanierController::class, 'modifier'])->name('panier.modifier');


// Authentification admin
Route::get('/administrateur/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/administrateur/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/administrateur/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Routes protégées par middleware admin
Route::middleware(['admin.auth'])->group(function () {

    // Tableau de bord admin
    Route::get('/administrateur', [AdminController::class, 'index'])->name('back.accueil');

    // Gestion des articles
    Route::get('/administrateur/articles', [ArticleController::class, 'index'])->name('back.articles.liste');
    Route::get('/administrateur/articles/create', [ArticleController::class, 'create'])->name('back.articles.create');
    Route::post('/administrateur/articles/create', [ArticleController::class, 'store'])->name('back.articles.store');
    Route::get('/administrateur/articles/{article}/editer', [ArticleController::class, 'edit'])->name('back.articles.edit');
    Route::get('/administrateur/articles/{article}', [ArticleController::class, 'show'])->name('back.articles.show');
    Route::put('/administrateur/articles/{article}', [ArticleController::class, 'update'])->name('back.articles.update');
    Route::delete('/administrateur/articles/{article}', [ArticleController::class, 'destroy'])->name('back.articles.destroy');

    // Gestion des commandes
    Route::get('/administrateur/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::delete('/administrateur/commandes/{id}', [CommandeController::class, 'destroy'])->name('admin.commandes.destroy');
    Route::get('/administrateur/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/administrateur/commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/administrateur/commandes/{id}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
    Route::put('/administrateur/commandes/{id}', [CommandeController::class, 'update'])->name('commandes.update');

    // Pour basculer l'état livraison
    Route::patch('/{commande}/toggle-livree', [CommandeController::class, 'toggleLivree'])->name('commandes.toggleLivree');

    // Gestion des contacts/messages
    Route::get('/administrateur/messages', [ContactController::class, 'index'])->name('admin.message');
    Route::delete('/administrateur/messages/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Paramètres de l'administration
    Route::get('/administrateur/parametres', [ParametreController::class, 'parametres'])->name('admin.parametres');

    Route::post('/administrateur/parametres', [ParametreController::class, 'updateParametres'])->name('admin.parametres.update');
    Route::put('/administrateur/parametres', [ParametreController::class, 'updateParametres'])->name('admin.parametres.update');

    Route::get('/administrateur/parametres/carrousel', [ParametreController::class, 'carrousel'])->name('admin.parametres.carrousel');
    Route::post('/administrateur/parametres/carrousel', [ParametreController::class, 'updateCarrousel'])->name('admin.parametres.carrousel.update');

    Route::get('message_diffusion/edit', [MessageDiffusionController::class, 'edit'])->name('admin.message_diffusion.edit');
    Route::post('message_diffusion/update', [MessageDiffusionController::class, 'update'])->name('admin.message_diffusion.update');

    Route::get('/administrateur/parametres/compte', [ParametreController::class, 'compte'])->name('admin.parametres.compte');
    Route::post('/administrateur/parametres/compte', [ParametreController::class, 'updateCompte'])->name('admin.parametres.compte.update');
});
