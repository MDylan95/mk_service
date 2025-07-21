<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Afficher tous les articles
    public function index()
    {
        $articles = Article::paginate(10);
        return view('back.articles.liste', compact('articles'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('back.articles.create');
    }

    // Enregistrer un nouvel article
    public function store(Request $request)
    {
        $request->merge([
            'prix' => str_replace(',', '.', $request->prix),
        ]);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prix' => 'required|numeric',
         ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $filename = Str::random(20) . '.' . $request->image->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('images', $filename, 'public');
            $imagePath = $path;
        }

        Article::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'image' => $imagePath,
            'prix' => $request->prix,
            'utilisateur_id' => auth()->check() ? auth()->id() : 1,
            'en_ligne' => $request->has('en_ligne'),
        ]);

        $this->updateCodeArticles();

        return redirect()->route('back.articles.liste')->with('success', 'Article ajouté avec succès.');
    }

    // Afficher un article
    public function show(Article $article)
    {
        return view('back.articles.show', compact('article'));
    }

    // Afficher le formulaire de modification
    public function edit(Article $article)
    {
        return view('back.articles.edit', compact('article'));
    }

    // Mettre à jour un article
    public function update(Request $request, Article $article)
    {
        $request->merge([
            'prix' => str_replace(',', '.', $request->prix),
        ]);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prix' => 'required|numeric',
         ]);

        if ($request->hasFile('image')) {
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }

            $filename = Str::random(20) . '.' . $request->image->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('images', $filename, 'public');
            $article->image = $path;
        }

        $article->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'image' => $article->image,
            'prix' => $request->prix,
         ]);

        return redirect()->route('back.articles.liste')->with('success', 'Article mis à jour avec succès.');
    }

    // Supprimer un article
    public function destroy(Article $article)
    {
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        $this->updateCodeArticles();

        return redirect()->route('back.articles.liste')->with('success', 'Article supprimé avec succès.');
    }

    // Recalculer les codes articles
    private function updateCodeArticles()
    {
        $articles = Article::orderBy('created_at')->get();
        foreach ($articles as $index => $article) {
            $article->code_article = 'ART-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $article->save();
        }
    }
}
