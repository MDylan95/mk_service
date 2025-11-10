@extends('back.dashboard')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white fw-bold fs-5 rounded-top-4">
            Enregistrement de l'article
        </div>
        <div class="card-body">

            <!-- Formulaire d'ajout d'article -->
            <form action="{{ route('back.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Titre -->
                <div class="mb-4">
                    <label for="titre" class="form-label fw-semibold">Titre de l'article</label>
                    <input type="text" name="titre" class="form-control form-control-lg @error('titre') is-invalid @enderror" id="titre"
                        placeholder="Entrez le titre" value="{{ old('titre') }}" required>
                    @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" name="description"
                        id="description" rows="5" placeholder="Entrez la description" required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold">Image</label>
                    <input type="file" name="image" id="image"
                        class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Formats acceptés : jpg, png, gif. Max 2MB.</small>

                    <!-- Aperçu image et bouton supprimer -->
                    <div class="mt-3 text-center" id="imagePreviewContainer" style="display: none;">
                        <img id="imagePreview" src="#" alt="Aperçu de l'image" class="img-thumbnail rounded-4 shadow-sm"
                            style="max-width: 250px;">
                        <button type="button" id="removeImageBtn" class="btn btn-danger btn-sm mt-2">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </div>
                </div>

                <!-- Prix -->
                <div class="mb-4">
                    <label for="prix" class="form-label fw-semibold">Prix</label>
                    <input type="text" name="prix" class="form-control form-control-lg @error('prix') is-invalid @enderror" id="prix"
                        placeholder="Ex: 10000 ou 10.000" value="{{ old('prix') }}" required>
                    @error('prix')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-center mt-4 gap-3">
                    <!-- Bouton Retour -->
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm fw-bold shadow-sm px-4">
                        <i class="fas fa-arrow-left me-2"></i> Annuler
                    </a>

                    <!-- Bouton Enregistrer -->
                    <button type="submit" class="btn btn-success btn-sm fw-bold shadow-sm px-4">
                        <i class="fas fa-plus me-2"></i> Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const removeImageBtn = document.getElementById('removeImageBtn');

    // Afficher l'aperçu quand une image est sélectionnée
    imageInput.addEventListener('change', function() {
        const [file] = this.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreviewContainer.style.display = 'block';
        } else {
            imagePreview.src = '#';
            imagePreviewContainer.style.display = 'none';
        }
    });

    // Supprimer l'image sélectionnée
    removeImageBtn.addEventListener('click', function() {
        imageInput.value = ''; // réinitialise l'input file
        imagePreview.src = '#';
        imagePreviewContainer.style.display = 'none';
    });
</script>

@endsection