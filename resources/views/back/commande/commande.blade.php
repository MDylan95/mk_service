@extends('back.dashboard')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold text-primary">📦 Mes Commandes</h2>

    <div class="mb-3 d-flex justify-content-center align-items-center gap-3 flex-wrap">
        <a href="{{ route('commandes.create') }}" class="btn btn-success fw-bold">
            ➕ Ajouter une commande
        </a>

        <form id="filterForm" method="GET" action="{{ route('commandes.index') }}" class="m-0">
            <select name="type" id="typeFilter" class="form-select w-auto" aria-label="Filtrer par type">
                <option value="">Tous les types</option>
                <option value="site" {{ request('type') === 'site' ? 'selected' : '' }}>Site</option>
                <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </form>
    </div>

    <div class="table-responsive shadow rounded p-3 bg-white">
        <table class="table table-hover align-middle table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Téléphone</th>
                    <th>Lieu</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Articles</th>
                    <th>Livrée</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($commandes as $commande)
                @php
                $articlesData = $commande->articles->map(function ($a) {
                return [
                'titre' => $a->titre,
                'image' => $a->image ? asset("storage/{$a->image}") : asset('images/default.png'),
                'prix' => $a->pivot->prix_unitaire,
                'quantite' => $a->pivot->quantite,
                ];
                });

                $tarifTotal = $commande->articles->sum(fn($a) => $a->pivot->prix_unitaire * $a->pivot->quantite);

                $typeLabel = match($commande->type) {
                'admin' => 'Admin',
                'site' => 'Site',
                default => ucfirst($commande->type),
                };
                @endphp
                <tr>
                    <td>{{ $loop->iteration + ($commandes->currentPage() - 1) * $commandes->perPage() }}</td>
                    <td>
                        <strong>{{ $commande->nom }}</strong><br>
                        <small class="text-muted">{{ $commande->prenom }}</small>
                    </td>
                    <td>{{ $commande->telephone }}</td>
                    <td>{{ $commande->lieu_livraison }}</td>
                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td><span class="badge bg-info text-dark">{{ $typeLabel }}</span></td>
                    <td style="min-width: 180px;">
                        @if ($commande->articles->isNotEmpty())
                        <ul class="list-unstyled mb-0 d-flex flex-wrap gap-2">
                            @foreach ($commande->articles as $article)
                            <li class="d-flex align-items-center" style="min-width: 150px;">
                                <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('images/default.png') }}"
                                    class="img-thumbnail me-2"
                                    alt="{{ $article->titre }}"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                                <span class="small fw-semibold">{{ $article->titre }}</span>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-muted small fst-italic">Aucun</span>
                        @endif
                    </td>
                    <td>
                        @if ($commande->livree)
                        <span class="badge bg-success">Oui</span>
                        @else
                        <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td style="min-width: 140px;">
                        <button type="button" class="btn btn-sm btn-outline-info mb-1 w-100 voir-btn"
                            data-nom="{{ $commande->nom }}"
                            data-prenom="{{ $commande->prenom }}"
                            data-telephone="{{ $commande->telephone }}"
                            data-quantite="{{ $commande->quantite }}"
                            data-lieu="{{ $commande->lieu_livraison }}"
                            data-total="{{ number_format($tarifTotal, 2, '.', '') }}"
                            data-articles='@json($articlesData)'>
                            👁️ Voir
                        </button>

                        <form method="POST" action="{{ route('admin.commandes.destroy', $commande->id) }}" class="d-inline delete-form" onsubmit="return false;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 mt-1">
                                🗑 Supprimer
                            </button>
                        </form>

                        <form action="{{ route('commandes.toggleLivree', $commande) }}" method="POST" class="mt-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-{{ $commande->livree ? 'secondary' : 'success' }} w-100">
                                {{ $commande->livree ? '↩️ Marquer non livrée' : '✅ Marquer livrée' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted fst-italic">Aucune commande trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $commandes->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Confirmation suppression
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Supprimer ?',
                text: 'Cette action est irréversible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Détails commande
    document.querySelectorAll('.voir-btn').forEach(button => {
        button.addEventListener('click', () => {
            const articles = JSON.parse(button.dataset.articles);
            let articleHtml = '';
            articles.forEach(a => {
                articleHtml += `
                    <div class="d-flex align-items-center mb-2">
                        <img src="${a.image}" alt="${a.titre}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;" class="me-2">
                        <div>
                            <strong>${a.titre}</strong><br>
                            <small>${a.quantite} x ${a.prix} F CFA</small>
                        </div>
                    </div>`;
            });

            Swal.fire({
                title: `${button.dataset.nom} ${button.dataset.prenom}`,
                html: `
                    <p><strong>Téléphone :</strong> ${button.dataset.telephone}</p>
                    <p><strong>Lieu :</strong> ${button.dataset.lieu}</p>
                    <p><strong>Quantité totale :</strong> ${button.dataset.quantite}</p>
                    <p><strong>Montant total :</strong> ${button.dataset.total} F CFA</p>
                    <hr>
                    ${articleHtml}
                `,
                width: 600,
                showCloseButton: true,
                focusConfirm: false,
                confirmButtonText: 'Fermer'
            });
        });
    });

    // Filtrage instantané par type
    document.getElementById('typeFilter').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>

@endsection