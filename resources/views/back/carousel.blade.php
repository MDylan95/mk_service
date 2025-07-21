@extends('back.dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center fw-bold">Gestion des images de couverture</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    @endif

    <form action="{{ route('admin.parametres.carrousel.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        @foreach($slides as $slide)
        <div class="mb-4">
            <label for="slide{{ $slide->position }}" class="form-label fw-semibold">Image {{ $slide->position }}</label><br>

            @if($slide->image_path)
            <img id="currentImage{{ $slide->position }}" src="{{ asset('storage/' . $slide->image_path) }}"
                alt="Image {{ $slide->position }}" style="max-height: 200px;" class="mb-2 img-thumbnail">
            @else
            <img id="currentImage{{ $slide->position }}" src="#" alt="Aperçu de l'image"
                style="max-height: 200px; display:none;" class="mb-2 img-thumbnail">
            @endif

            <input type="file" name="slide{{ $slide->position }}" id="slide{{ $slide->position }}" class="form-control" accept="image/*" aria-describedby="helpSlide{{ $slide->position }}">
            <div id="helpSlide{{ $slide->position }}" class="form-text">Choisissez une image pour la diapositive {{ $slide->position }}.</div>
        </div>
        @endforeach

        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($slides as $slide)
        document.getElementById('slide{{ $slide->position }}').addEventListener('change', function(event) {
            const [file] = this.files;
            const preview = document.getElementById('currentImage{{ $slide->position }}');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });
        @endforeach
    });
</script>
@endpush
@endsection