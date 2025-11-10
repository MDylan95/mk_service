@extends('front.layout.index')
@section('content')

<section id="contact" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center fw-bold mb-2" style="font-family: 'Playfair Display', serif; font-size: 2rem; color:#000;">
            Contactez-nous
        </h2>

        <p class="text-center text-muted mb-4" style="font-size: 1.05rem; font-style: italic;">
            Contactez-nous en cas de besoin, nous sommes à votre écoute.
        </p>

        {{-- Messages de succès --}}
        @if (session('success'))
        <div class="alert alert-success text-center shadow-sm rounded-3">
            {{ session('success') }}
        </div>
        @endif

        {{-- Messages d'erreur --}}
        @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row justify-content-center align-items-center mt-4">
            {{-- Logo --}}
            <div class="col-md-4 mb-4 mb-md-0 text-center">
                <img src="{{ asset('Images/logo.png') }}" alt="Logo MK Service" class="img-fluid rounded-3 shadow" style="max-height: 250px;">
            </div>

            {{-- Formulaire --}}
            <div class="col-md-6">
                <div class="card shadow-sm rounded-4 border-0 p-4" style="background-color:#fff;">
                    <form action="{{ route('front.contact.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label fw-semibold text-dark">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control rounded-3 @error('nom') is-invalid @enderror" placeholder="Votre nom" value="{{ old('nom') }}" required>
                            @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label fw-semibold text-dark">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control rounded-3 @error('prenom') is-invalid @enderror" placeholder="Votre prénom" value="{{ old('prenom') }}" required>
                            @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label fw-semibold text-dark">Numéro de téléphone (WhatsApp de préférence)</label>
                            <input type="text" name="telephone" id="telephone" class="form-control rounded-3 @error('telephone') is-invalid @enderror" placeholder="+225 00 00 00 00 00" value="{{ old('telephone') }}" required>
                            @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold text-dark">Message</label>
                            <textarea name="message" id="message" class="form-control rounded-3 @error('message') is-invalid @enderror" rows="5" placeholder="Votre message..." required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-dark w-100 rounded-pill fw-semibold">
                            Envoyer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection