@extends('front.layout.index')
@section('content')

<section id="articles" class="py-4 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold" style="font-family: 'Playfair Display', serif; font-size: 1.8rem;">Nos Articles</h2>

        <!-- Barre de recherche -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('front.articles') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Rechercher un article..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Rechercher</button>
                </form>
            </div>
        </div>

        <div class="row g-3 justify-content-center">
            @forelse ($articles as $article)
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-3 mx-auto" style="max-width: 300px;">
                    <div class="bg-white p-2 rounded-top-3" style="height: 220px; display: flex; justify-content: center; align-items: center;">
                        <img src="{{ asset('storage/' . $article->image) }}" class="img-fluid" alt="{{ $article->titre }}" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center p-2">
                        <h6 class="card-title fw-bold mb-1">{{ $article->titre }}</h6>
                        <p class="card-text text-muted small mb-1">{{ $article->description }}</p>
                        <p class="text-primary fw-semibold mb-2" style="font-size: 0.95rem;">{{ number_format($article->prix, 0, ',', ' ') }} FCFA</p>
                        <button class="btn btn-sm btn-outline-primary rounded-pill ajouter-au-panier" data-id="{{ $article->id }}">
                            Ajouter au panier
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Aucun article trouvé pour cette recherche.</p>
            @endforelse
        </div>

        {{-- Pagination si besoin --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $articles->appends(request()->all())->links() }}
        </div>
    </div>
</section>

<!-- Toast de confirmation -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="toastPanier" class="toast align-items-center text-bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                ✅ Article ajouté au panier !
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const boutonsAjouter = document.querySelectorAll('.ajouter-au-panier');

        boutonsAjouter.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch("{{ route('panier.ajouter') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const toastEl = document.getElementById('toastPanier');
                            const toast = new bootstrap.Toast(toastEl, {
                                delay: 3000
                            });
                            toast.show();
                        } else {
                            alert("Une erreur s'est produite.");
                        }
                    })
                    .catch(() => {
                        alert("Erreur de connexion.");
                    });
            });
        });
    });
</script>
@endsection

@endsection