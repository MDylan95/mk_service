@extends('back.dashboard')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center fw-bold">
            Ajouter une commande
        </div>

        <div class="card-body">

            @if ($errors->any())
            <div class="alert alert-danger">
                <h6 class="fw-bold">Erreurs :</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('commandes.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lieu_livraison" class="form-label">Lieu de Livraison</label>
                        <input type="text" name="lieu_livraison" id="lieu_livraison" class="form-control" value="{{ old('lieu_livraison') }}" required>
                    </div>
                </div>

                <div class="mt-4">
                    <h5 class="text-secondary fw-bold">Articles</h5>
                    <p class="text-muted">Sélectionnez les articles à ajouter à la commande :</p>

                    <div class="row">
                        @foreach ($articles as $article)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="border rounded p-3 h-100 d-flex flex-column shadow-sm">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ asset('storage/' . $article->image) }}"
                                        alt="{{ $article->titre }}"
                                        class="rounded me-3"
                                        style="width: 60px; height: 60px; object-fit: cover;">

                                    <div>
                                        <strong>{{ $article->titre }}</strong><br>
                                        <small class="text-muted">{{ number_format($article->prix, 2) }} F CFA</small>
                                    </div>
                                </div>

                                <div class="form-check mb-2">
                                    <input
                                        class="form-check-input article-checkbox"
                                        type="checkbox"
                                        id="article_{{ $article->id }}"
                                        name="articles[{{ $article->id }}][enabled]"
                                        value="1">
                                    <label class="form-check-label" for="article_{{ $article->id }}">
                                        Ajouter à la commande
                                    </label>
                                </div>

                                <div class="d-flex align-items-center mt-auto">
                                    <label for="quantite_{{ $article->id }}" class="me-2 mb-0">Quantité :</label>
                                    <input
                                        type="number"
                                        name="articles[{{ $article->id }}][quantite]"
                                        id="quantite_{{ $article->id }}"
                                        min="1"
                                        value="1"
                                        class="form-control form-control-sm article-quantity"
                                        style="width: 80px;"
                                        disabled>
                                </div>

                                <input type="hidden" name="articles[{{ $article->id }}][prix]" value="{{ $article->prix }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="1" id="livree" name="livree" {{ old('livree') ? 'checked' : '' }}>
                    <label class="form-check-label" for="livree">
                        Livraison déjà effectuée
                    </label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('commandes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-success fw-bold">
                        <i class="bi bi-save"></i> Enregistrer la commande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script pour activer/désactiver les quantités --}}
<script>
    document.querySelectorAll('.article-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const quantityInput = this.closest('.border').querySelector('.article-quantity');
            quantityInput.disabled = !this.checked;
            if (!this.checked) quantityInput.value = 1;
        });
    });
</script>
@endsection