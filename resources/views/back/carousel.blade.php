@extends('back.dashboard')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Gestion des images de couverture</h1>
        <a href="{{ route('admin.parametres') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    @endif

    <form action="{{ route('admin.parametres.carrousel.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row g-4">
            @foreach($slides as $slide)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title fw-semibold mb-3">Image {{ $slide->position }}</h5>

                        <div class="mb-3 w-100 text-center">
                            @if($slide->image_path)
                            <img id="currentImage{{ $slide->position }}" src="{{ asset('storage/' . $slide->image_path) }}"
                                alt="Image {{ $slide->position }}" class="img-fluid rounded border img-thumbnail" style="max-height:200px;">
                            @else
                            <img id="currentImage{{ $slide->position }}" src="#" alt="Aperçu de l'image"
                                class="img-fluid rounded border img-thumbnail" style="max-height:200px; display:none;">
                            @endif
                        </div>

                        <input type="file" name="slide{{ $slide->position }}" id="slide{{ $slide->position }}"
                            class="form-control" accept="image/*" aria-describedby="helpSlide{{ $slide->position }}">
                        <div id="helpSlide{{ $slide->position }}" class="form-text text-center mt-1">
                            Choisissez une image pour la diapositive {{ $slide->position }}.
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
                <i class="fas fa-save me-2"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($slides as $slide)
        const input {
            {
                $slide - > position
            }
        } = document.getElementById('slide{{ $slide->position }}');
        const preview {
            {
                $slide - > position
            }
        } = document.getElementById('currentImage{{ $slide->position }}');

        input {
            {
                $slide - > position
            }
        }.addEventListener('change', function(event) {
            const [file] = this.files;
            if (file) {
                preview {
                    {
                        $slide - > position
                    }
                }.src = URL.createObjectURL(file);
                preview {
                    {
                        $slide - > position
                    }
                }.style.display = 'block';
            } else {
                preview {
                    {
                        $slide - > position
                    }
                }.src = '#';
                preview {
                    {
                        $slide - > position
                    }
                }.style.display = 'none';
            }
        });
        @endforeach
    });
</script>
@endpush
@endsection