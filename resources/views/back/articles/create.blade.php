@extends('back.dashboard')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">Enregistrement de l'article</div>
        <div class="card-body">
            <!-- Formulaire d'ajout d'article -->
            <form action="{{ route('back.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Titre -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de l'article</label>
                    <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" id="titre"
                        placeholder="Entrez le titre" value="{{ old('titre') }}" required>
                    @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                        id="description" rows="3" placeholder="Entrez la description" required>{{ old('description') }}</textarea>
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

                    <!-- Aperçu image -->
                    <div class="mt-3">
                        <img id="imagePreview" src="#" alt="Aperçu de l'image" class="img-thumbnail"
                            style="max-width: 200px; display: none;">
                    </div>
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input type="text" name="prix" class="form-control @error('prix') is-invalid @enderror" id="prix"
                        placeholder="Ex: 10000 ou 10.000" value="{{ old('prix') }}" required>
                    @error('prix')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const [file] = this.files;
        const preview = document.getElementById('imagePreview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });
</script>

@endsection