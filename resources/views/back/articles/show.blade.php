@extends('back.dashboard')

@section('content')
<div class="container mt-5">

    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-gradient-primary text-white fw-bold fs-5 rounded-top-4">
            Détails de l'article
        </div>
        <div class="card-body">

            <!-- Nom de l'article -->
            <p class="mb-3"><strong>Nom de l'article :</strong> <span class="fw-semibold">{{ $article->titre }}</span></p>

            <!-- Image -->
            @if ($article->image)
            <div class="mb-4 text-center">
                <img src="{{ asset('storage/' . $article->image) }}"
                    alt="Image de {{ $article->titre }}"
                    class="img-fluid rounded shadow-sm"
                    style="max-width: 300px;">
            </div>
            @else
            <p class="text-muted fst-italic text-center">Aucune image disponible</p>
            @endif

            <!-- Description -->
            <p class="mb-3"><strong>Description :</strong> {{ $article->description }}</p>

            <!-- Prix -->
            <p class="mb-0"><strong>Prix :</strong> <span class="text-success fw-semibold">{{ number_format($article->prix, 0, ',', ' ') }} F CFA</span></p>
        </div>
    </div>

    <!-- Bouton retour -->
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('back.articles.liste') }}" class="btn btn-secondary btn-sm fw-bold px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
        </a>
    </div>

</div>
@endsection