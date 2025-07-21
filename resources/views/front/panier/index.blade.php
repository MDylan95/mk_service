@extends('Front.layout.index')

@section('content')
<div class="container py-5">
    {{-- ✅ Message de succès commande --}}
    @if(session('commande_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('commande_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- ✅ Autres messages --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (count($panier) > 0)
    <table class="table table-bordered shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Article</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($panier as $id => $article)
            @php $total += $article['prix'] * $article['quantite']; @endphp
            <tr>
                <td><img src="{{ asset('storage/' . $article['image']) }}" width="60" alt=""></td>
                <td>{{ $article['titre'] }}</td>
                <td>{{ number_format($article['prix'], 2) }} F CFA</td>
                <td>
                    <form action="{{ route('panier.modifier', $id) }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantite" value="{{ $article['quantite'] }}" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                        <button type="submit" class="btn btn-sm btn-primary">OK</button>
                    </form>
                </td>
                <td>{{ number_format($article['prix'] * $article['quantite'], 2) }} F CFA</td>
                <td>
                    <a href="{{ route('panier.supprimer', $id) }}" class="btn btn-danger btn-sm">🗑</a>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-end fw-bold">Total :</td>
                <td colspan="2" class="fw-bold">{{ number_format($total, 2) }} F CFA</td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('panier.vider') }}" class="btn btn-outline-danger">Vider le panier</a>

    <button class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#commandeModal">
        ✅ Valider la commande
    </button>
    @else
    <div class="text-center mt-5 p-5 border rounded bg-light shadow-sm">
        <i class="bi bi-cart-x display-4 text-muted"></i>
        <h4 class="mt-3 text-muted">Votre panier est vide.</h4>
        <a href="{{ route('front.articles') }}" class="btn btn-outline-primary mt-3">← Voir les articles</a>
    </div>
    @endif
</div>

<!-- ✅ MODAL de validation de commande -->
<div class="modal fade" id="commandeModal" tabindex="-1" aria-labelledby="commandeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('panier.valider.post') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="commandeModalLabel">Finaliser la commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                {{-- ✅ Affichage des erreurs --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="row">
                    <div class="col mb-2">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                    </div>
                    <div class="col mb-2">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" name="telephone" class="form-control" value="{{ old('telephone') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lieu de livraison</label>
                    <input type="text" name="lieu_livraison" class="form-control" value="{{ old('lieu_livraison') }}" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">✅ Confirmer la commande</button>
            </div>
        </form>
    </div>
</div>
@endsection