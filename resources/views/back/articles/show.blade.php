@extends('back.dashboard')

@section('content')
<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Détails de l'article
        </div>
        <div class="card-body">
            <p><strong>Nom de l'article :</strong> {{ $article->titre }}</p>

            @if ($article->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $article->image) }}"
                    alt="Image de {{ $article->titre }}"
                    class="img-fluid rounded"
                    style="max-width: 300px;">
            </div>
            @else
            <p class="text-muted fst-italic">Aucune image disponible</p>
            @endif

            <p><strong>Description :</strong> {{ $article->description }}</p>

            

            <p><strong>Prix :</strong> {{ number_format($article->prix, 0, ',', ' ') }} F CFA</p>
        </div>
    </div>

    <a href="{{ route('back.articles.liste') }}" class="btn btn-secondary mt-3">← Retour à la liste</a>

</div>
@endsection