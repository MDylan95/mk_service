@extends('back.dashboard')
@section('content')

<div class="container mt-5">
    <h2 class="mb-4 text-center">Modifier l'article</h2>
    <form action="{{ route('back.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Titre -->
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" value="{{ old('titre', $article->titre) }}" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required>{{ old('description', $article->description) }}</textarea>
        </div>

        

        <!-- Prix -->
        <div class="mb-3">
            <label class="form-label">Prix (F CFA)</label>
            <input type="number" name="prix" value="{{ old('prix', $article->prix) }}" class="form-control" step="0.01" min="0" inputmode="decimal" required>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            @if ($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle" width="100" class="mt-2 rounded shadow-sm">
            @endif
        </div>

        <!-- En ligne -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="en_ligne" id="en_ligne" class="form-check-input"
                {{ old('en_ligne', $article->en_ligne) ? 'checked' : '' }}>
            <label for="en_ligne" class="form-check-label">Publié</label>
        </div>

        <!-- Boutons -->
        <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        <a href="{{ route('back.articles.liste') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

@endsection