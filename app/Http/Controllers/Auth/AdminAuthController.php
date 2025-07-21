<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion pour l'administrateur.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('back.accueil');
        }

        return view('back.connexion.login');
    }

    /**
     * Traite la tentative de connexion de l'administrateur.
     */
    public function login(Request $request)
    {
        // Valide les champs du formulaire
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Récupère l'utilisateur ayant l'email fourni
        $admin = Utilisateur::where('email', $request->email)->first();

        // Vérifie que l'utilisateur existe et que le mot de passe est correct
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Connecte l'utilisateur avec Auth
            Auth::login($admin);

            return redirect()->route('back.accueil')->with('success', 'Connecté avec succès');
        }

        // Si l'authentification échoue
        return back()->withErrors(['email' => 'Email ou mot de passe incorrect']);
    }

    /**
     * Déconnecte l'administrateur.
     */
    public function logout()
    {
        Auth::logout(); // ← Utilise le système propre de Laravel

        return redirect()->route('admin.login')->with('success', 'Déconnecté');
    }
}
