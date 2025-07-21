<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\Contact;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $utilisateur = auth('web')->user();

        $articlesCount = Article::count();

        // Ici on récupère les messages non lus
        $messagesNonLusCount = Contact::where('lu', false)->count();

        // Ici on récupère les commandes non lues
        $commandesNonLuesCount = Commande::where('lu', false)->count();

        return view('back.accueil', [
            'name' => $utilisateur ? $utilisateur->nom : 'Utilisateur inconnu',
            'articlesCount' => $articlesCount,
            'messagesNonLusCount' => $messagesNonLusCount,
            'commandesNonLuesCount' => $commandesNonLuesCount,
        ]);
    }

    
}
