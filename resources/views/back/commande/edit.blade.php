@extends('back.dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold text-primary">Modifier la commande #{{ $commande->id }}</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $commande->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $commande->prenom) }}" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $commande->telephone) }}" required>
        </div>

        <div class="mb-3">
            <label for="lieu_livraison" class="form-label">Lieu de Livraison</label>
            <input type="text" name="lieu_livraison" id="lieu_livraison" class="form-control" value="{{ old('lieu_livraison', $commande->lieu_livraison) }}" required>
        </div>

        <h5>Articles</h5>
        <p>Modifiez les articles et leurs quantités</p>

        <div id="articles-container" class="mb-3">
            @foreach ($articles as $article)
            @php
            $checked = isset($articlesCommande[$article->id]);
            $quantite = $checked ? $articlesCommande[$article->id]['quantite'] : 1;
            $prix = $checked ? $articlesCommande[$article->id]['prix'] : $article->prix;
            @endphp

            <div class="form-check mb-1 d-flex align-items-center gap-2">
                <input
                    class="form-check-input article-checkbox"
                    type="checkbox"
                    value="{{ $article->id }}"
                    id="article_{{ $article->id }}"
                    name="contenu_panier[{{ $article->id }}][id]"
                    {{ $checked ? 'checked' : '' }}>

                <label class="form-check-label" for="article_{{ $article->id }}">
                    {{ $article->titre }} (Prix unitaire: {{ number_format($article->prix, 2) }} F CFA)
                </label>

                <input
                    type="number"
                    name="contenu_panier[{{ $article->id }}][quantite]"
                    min="1"
                    value="{{ old('contenu_panier.' . $article->id . '.quantite', $quantite) }}"
                    class="form-control form-control-sm ms-3 article-quantity"
                    style="width: 80px;"
                    {{ $checked ? '' : 'disabled' }}>

                <input type="hidden" name="contenu_panier[{{ $article->id }}][prix]" value="{{ $prix }}">
            </div>
            @endforeach
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="livree" name="livree" {{ old('livree', $commande->livree) ? 'checked' : '' }}>
            <label class="form-check-label" for="livree">
                Livraison effectuée
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script>
    document.querySelectorAll('.article-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const quantiteInput = this.parentElement.querySelector('.article-quantity');
            quantiteInput.disabled = !this.checked;
            if (!this.checked) quantiteInput.value = 1;
        });
    });
</script>
@endsection