<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Commande;

class PanierController extends Controller
{
    public function index()
    {
        $panier = session()->get('panier', []);
        return view('front.panier.index', compact('panier'));
    }

    public function ajouter(Request $request)
    {
        $id = $request->input('id');
        $article = Article::findOrFail($id);

        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite'] += 1;
        } else {
            $panier[$id] = [
                'id' => $article->id,
                'titre' => $article->titre,
                'prix' => $article->prix,
                'image' => $article->image,
                'quantite' => 1
            ];
        }

        session(['panier' => $panier]);

        return response()->json(['success' => true]);
    }

    public function modifier(Request $request, $id)
    {
        $quantite = $request->input('quantite');

        if ($quantite <= 0) {
            return redirect()->back()->with('error', 'La quantité doit être supérieure à zéro.');
        }

        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite'] = $quantite;
            session()->put('panier', $panier);
            return redirect()->back()->with('success', 'Quantité mise à jour.');
        }

        return redirect()->back()->with('error', 'Article non trouvé dans le panier.');
    }

    public function supprimer($id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        return redirect()->back()->with('success', 'Article supprimé du panier.');
    }

    public function afficherFormulaireCommande()
    {
        $panier = session()->get('panier', []);
        return view('front.panier.index', compact('panier'));
    }

    public function valider(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'lieu_livraison' => 'required|string|max:255',
        ]);

        $panier = session()->get('panier', []);

        if (empty($panier)) {
            return redirect()->route('front.article')->with('error', 'Votre panier est vide.');
        }

        $quantiteTotale = array_sum(array_column($panier, 'quantite'));

        $commande = Commande::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $data['telephone'],
            'lieu_livraison' => $data['lieu_livraison'],
            'quantite' => $quantiteTotale,
            'lu' => false,
        ]);

        foreach ($panier as $articleId => $item) {
            $commande->articles()->attach($articleId, [
                'quantite' => $item['quantite'],
                'prix_unitaire' => $item['prix'],
            ]);
        }

        // ✅ Vider le panier
        session()->forget('panier');

        // ✅ Rediriger vers le panier avec un message de succès spécifique
        return redirect()->route('panier.index')->with('commande_success', 'Votre commande a bien été enregistrée ! Un conseiller client vous contactera dans les plus brefs délais.');
    }

    public function vider()
    {
        session()->forget('panier');
        return redirect()->back()->with('success', 'Panier vidé.');
    }
}
