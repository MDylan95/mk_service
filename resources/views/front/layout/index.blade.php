<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MK Service</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Images/logo.jpg') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Montserrat&display=swap" rel="stylesheet" />

    <!-- Ton fichier CSS -->
    <link rel="stylesheet" href="{{ asset('front/css/styles.css') }}" />
</head>

<body style="min-height:100vh;display:flex;flex-direction:column;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('front.accueil') }}">
                <img src="{{ asset('Images/logo.jpg') }}" alt="Logo MK Service" style="height: 100px;">
                <span class="fw-bold" style="font-family: 'Playfair Display', serif;">MK Service</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'front.accueil' ? 'active custom-active' : '' }}" href="{{ route('front.accueil') }}">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'front.articles' ? 'active custom-active' : '' }}" href="{{ route('front.articles') }}">
                            Nos articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'front.contact' ? 'active custom-active' : '' }}" href="{{ route('front.contact') }}">
                            Contactez-nous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative {{ Str::startsWith(Route::currentRouteName(), 'panier.') ? 'active custom-active' : '' }}" href="{{ route('panier.index') }}">
                            <i class="bi bi-cart" style="font-size: 1.2rem;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ session('panier') ? count(session('panier')) : 0 }}
                            </span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Marge haute pour compenser la navbar fixe -->
    <div style="padding-top: 70px;"></div>

    <!-- Contenu principal -->
    <main style="flex:1 0 auto;">
        @yield('content')
    </main>

    @yield('scripts')


    <!-- Footer -->
    <footer class="footer bg-dark text-light py-5 mt-5" style="flex-shrink:0;">
        <div class="container">
            <div class="row gy-4">
                <!-- Logo et nom -->
                <div class="col-md-4 text-center text-md-start">
                    <h5 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif;">MK Service</h5>
                    <p class="small text-muted">Mystère, luxe et tradition à chaque fragrance.</p>
                </div>

                <!-- Coordonnées -->
                <div class="col-md-4 text-center">
                    <h6 class="text-uppercase fw-bold mb-3">Contact</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Treichville , Abidjan, Côte d'Ivoire
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill me-2"></i>
                            +225 0767411462
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill me-2"></i>
                            Mickaeldabire@icloud.com
                        </li>
                    </ul>
                </div>

                <!-- Réseaux sociaux (exemple) -->
                <div class="col-md-4 text-center text-md-end">
                    <h6 class="text-uppercase fw-bold mb-3">Suivez-nous</h6>
                    <a href="https://www.facebook.com/profile.php?id=100093285176410" class="text-light me-3"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-whatsapp fs-5"></i></a>
                </div>
            </div>

            <hr class="my-4 border-light" />

            <div class="text-center small">
                &copy; 2025 MK Service — Tous droits réservés
            </div>
        </div>
    </footer>




    <!-- Bootstrap JS Bundle (Popper + Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</body>

</html>