@extends('back.dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center fw-bold">Message de diffusion</h1>

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

        <div class="mb-3">
            <label for="value" class="form-label fw-semibold">Message</label>
            <textarea
                name="value"
                id="value"
                rows="4"
                maxlength="500"
                required
                class="form-control @error('value') is-invalid @enderror"
                aria-describedby="valueHelp">{{ old('value', $message->value ?? '') }}</textarea>

            @error('value')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div id="valueHelp" class="form-text">Maximum 500 caractères.</div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
        </div>
    </form>
</div>
@endsection