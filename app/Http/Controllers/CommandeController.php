<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Article;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    // Liste des commandes avec filtrage par type
    public function index(Request $request)
    {
        $type = $request->query('type'); // Récupérer filtre

        $query = Commande::with('articles')->latest();

        if ($type && in_array($type, ['admin', 'site'])) {
            $query->where('type', $type);
        }

        $commandes = $query->paginate(10)->withQueryString();

        return view('back.commande.commande', compact('commandes', 'type'));
    }

    // Formulaire de création
    public function create()
    {
        $articles = Article::all();
        return view('back.commande.create', compact('articles'));
    }

    // Enregistrement d'une commande
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => ['required', 'string', 'regex:/^\+?[0-9\s\-]{7,15}$/'],
            'lieu_livraison' => 'required|string|max:255',
            'type' => 'nullable|string|in:site,admin',
            'articles' => 'nullable|array',
            'livree' => 'sometimes|boolean',
        ]);

        $articles = $request->input('articles', []);

        foreach ($articles as $id => $data) {
            if (isset($data['enabled'])) {
                $request->validate([
                    "articles.$id.quantite" => 'required|integer|min:1',
                    "articles.$id.prix" => 'required|numeric|min:0',
                ]);
            }
        }

        $commande = Commande::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'lieu_livraison' => $validated['lieu_livraison'],
            'quantite' => 0,
            'livree' => $request->boolean('livree'),
            // Forcer admin pour backend si non spécifié (manuellement)
            'type' => $validated['type'] ?? 'admin',
        ]);

        $totalQuantite = 0;

        foreach ($articles as $articleId => $articleData) {
            if (!isset($articleData['enabled'])) continue;

            $commande->articles()->attach($articleId, [
                'quantite' => $articleData['quantite'],
                'prix_unitaire' => $articleData['prix'],
            ]);

            $totalQuantite += $articleData['quantite'];
        }

        $commande->update(['quantite' => $totalQuantite]);

        return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès.');
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $commande = Commande::with('articles')->findOrFail($id);
        $articles = Article::all();

        $articlesCommande = $commande->articles->mapWithKeys(function ($article) {
            return [
                $article->id => [
                    'quantite' => $article->pivot->quantite,
                    'prix' => $article->pivot->prix_unitaire,
                ],
            ];
        })->toArray();

        return view('back.commande.edit', compact('commande', 'articles', 'articlesCommande'));
    }

    // Mise à jour
    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => ['required', 'string', 'regex:/^\+?[0-9\s\-]{7,15}$/'],
            'lieu_livraison' => 'required|string|max:255',
            'type' => 'nullable|string|in:site,admin',
            'articles' => 'nullable|array',
            'livree' => 'sometimes|boolean',
        ]);

        $articles = $request->input('articles', []);

        foreach ($articles as $id => $data) {
            if (isset($data['enabled'])) {
                $request->validate([
                    "articles.$id.quantite" => 'required|integer|min:1',
                    "articles.$id.prix" => 'required|numeric|min:0',
                ]);
            }
        }

        $commande->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'lieu_livraison' => $validated['lieu_livraison'],
            'livree' => $request->boolean('livree', $commande->livree),
            'type' => $validated['type'] ?? $commande->type,
        ]);

        $commande->articles()->detach();

        $totalQuantite = 0;
        foreach ($articles as $articleId => $articleData) {
            if (!isset($articleData['enabled'])) continue;

            $commande->articles()->attach($articleId, [
                'quantite' => $articleData['quantite'],
                'prix_unitaire' => $articleData['prix'],
            ]);

            $totalQuantite += $articleData['quantite'];
        }

        $commande->update(['quantite' => $totalQuantite]);

        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
    }

    // Suppression
    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->articles()->detach();
        $commande->delete();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimée avec succès.');
    }

    // Toggle livraison
    public function toggleLivree(Commande $commande)
    {
        $commande->livree = !$commande->livree;
        $commande->save();

        return redirect()->route('commandes.index')->with('success', 'État de livraison mis à jour.');
    }
}
