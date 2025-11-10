@extends('back.dashboard')

@section('content')
<div class="container py-4 position-relative">

    {{-- Bouton Retour flottant --}}
    <a href="{{ route('admin.parametres') }}"
        class="btn btn-secondary shadow-sm position-absolute top-0 start-0 m-3">
        <i class="fas fa-arrow-left me-2"></i> Retour
    </a>

    <div class="card shadow-lg rounded-4 border-0 mx-auto mt-5" style="max-width: 600px;">
        <div class="card-header bg-gradient-primary text-white fw-bold fs-5 rounded-top-4 text-center">
            Message de diffusion
        </div>

        <div class="card-body">

            {{-- Message de succès --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
            @endif

            {{-- Formulaire --}}
            <form action="{{ route('admin.message_diffusion.update') }}" method="POST" novalidate>
                @csrf

                <div class="mb-4">
                    <label for="value" class="form-label fw-semibold">Message</label>
                    <textarea
                        name="value"
                        id="value"
                        rows="5"
                        maxlength="500"
                        required
                        class="form-control form-control-lg @error('value') is-invalid @enderror"
                        aria-describedby="valueHelp">{{ old('value', $message->value ?? '') }}</textarea>

                    @error('value')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div id="valueHelp" class="form-text">Maximum 500 caractères.</div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm px-5">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection