@extends('back.dashboard')
@section('content')

<div class="container mt-5">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-gradient-primary text-white fw-bold fs-5 rounded-top-4">
            Modifier l'article
        </div>
        <div class="card-body">

            <form action="{{ route('back.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre', $article->titre) }}"
                        class="form-control form-control-lg @error('titre') is-invalid @enderror" required>
                    @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control form-control-lg @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $article->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Prix (F CFA)</label>
                    <input type="number" name="prix" value="{{ old('prix', $article->prix) }}"
                        class="form-control form-control-lg @error('prix') is-invalid @enderror" step="0.01" min="0" inputmode="decimal" required>
                    @error('prix')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Image</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($article->image)
                    <div class="mt-3 text-center" id="currentImageContainer">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle"
                            class="img-thumbnail rounded shadow-sm" style="max-width: 200px;">
                        <button type="button" class="btn btn-danger btn-sm mt-2" id="removeImageBtn">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </div>
                    @endif
                </div>



                <!-- Boutons -->
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-success btn-sm fw-bold px-4 shadow-sm">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                    <a href="{{ route('back.articles.liste') }}" class="btn btn-secondary btn-sm fw-bold px-4 shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i> Annuler
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    const removeBtn = document.getElementById('removeImageBtn');
    const currentImageContainer = document.getElementById('currentImageContainer');
    const imageInput = document.getElementById('image');

    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            currentImageContainer.style.display = 'none';
            imageInput.value = '';
        });
    }
</script>

@endsection