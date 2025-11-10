<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MK Service</title>
    <meta name="description" content="MK Service - Mystère, luxe et tradition à chaque fragrance.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Images/logo.png') }}" />

    <!-- Bootstrap CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Montserrat&display=swap" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('front/css/styles.css') }}" />

    <style>
        /* --- Navbar --- */
        .navbar-nav .nav-link {
            transition: color 0.3s ease;
            color: #000;
            position: relative;
        }

        /* Hover effect */
        .navbar-nav .nav-link:hover {
            color: #555;
        }

        /* Active link */
        .navbar-nav .nav-link.active {
            color: #000;
            font-weight: 700;
        }

        .navbar-nav .nav-link.active::after {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background-color: #000;
            margin-top: 2px;
            border-radius: 2px;
        }

        /* Icon panier hover */
        .nav-link i {
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.2);
        }

        /* --- Footer --- */
        .footer {
            background-color: #000;
            color: #fff;
        }

        .footer h5,
        .footer h6 {
            letter-spacing: 1px;
        }

        .footer .logo-footer {
            filter: brightness(0) invert(1);
            transition: transform 0.3s ease;
        }

        .footer .logo-footer:hover {
            transform: scale(1.05);
        }

        .footer a {
            background: #333;
            transition: all 0.3s ease;
        }

        .footer a:hover {
            background: #fff;
            color: #000 !important;
            transform: scale(1.1);
        }

        .footer p {
            opacity: 0.8;
        }

        /* Badge panier */
        .navbar .badge {
            font-size: 0.7rem;
        }
    </style>
</head>

<body style="min-height:100vh;display:flex;flex-direction:column;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('front.accueil') }}">
                <img src="{{ asset('Images/logo.png') }}" alt="Logo MK Service" style="height: 70px;">
                <span class="fw-bold" style="font-family: 'Playfair Display', serif;">MK Service</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'front.accueil' ? 'active' : '' }}" href="{{ route('front.accueil') }}">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'front.articles' ? 'active' : '' }}" href="{{ route('front.articles') }}">
                            Nos articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'front.contact' ? 'active' : '' }}" href="{{ route('front.contact') }}">
                            Contactez-nous
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'panier.') ? 'active' : '' }}" href="{{ route('panier.index') }}">
                            <i class="bi bi-cart fs-5"></i>
                            <span id="panier-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ session('panier') ? array_sum(array_column(session('panier'), 'quantite')) : 0 }}
                            </span>


                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Marge haute -->
    <div style="padding-top: 70px;"></div>

    <!-- Contenu principal -->
    <main style="flex:1 0 auto;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer pt-5 mt-5" style="flex-shrink:0;">
        <div class="container">
            <div class="row gy-5 align-items-start">
                <!-- Logo -->
                <div class="col-md-4 text-center mx-auto">
                    <img src="{{ asset('Images/logo.png') }}" alt="Logo MK Service" class="mb-3 logo-footer" style="height:70px;">
                    <h5 class="fw-bold mb-2" style="font-family: 'Playfair Display', serif;">MK Service</h5>
                    <p class="small fst-italic text-muted">Mystère, luxe et tradition à chaque fragrance.</p>
                </div>
                <!-- Coordonnées -->
                <div class="col-md-4 text-center text-md-start">
                    <h6 class="text-uppercase fw-bold mb-3 d-inline-block pb-1" style="border-bottom: 2px solid white;">Nous-Contacter</h6>
                    <ul class="list-unstyled small mt-2">
                        <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Treichville, Abidjan, Côte d'Ivoire</li>
                        <li class="mb-2"><i class="bi bi-telephone-fill me-2"></i>+225 0767411462</li>
                        <li><i class="bi bi-envelope-fill me-2"></i>Mickaeldabire@icloud.com</li>
                    </ul>
                </div>
                <!-- Réseaux sociaux -->
                <div class="col-md-4 text-center text-md-end">
                    <h6 class="text-uppercase fw-bold mb-3">Suivez-nous</h6>
                    <div class="d-flex justify-content-center justify-content-md-end gap-3">
                        <a href="https://www.facebook.com/profile.php?id=100093285176410" class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                            <i class="bi bi-facebook fs-5 text-white"></i>
                        </a>
                        <a href="#" class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                            <i class="bi bi-instagram fs-5 text-white"></i>
                        </a>
                        <a href="#" class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                            <i class="bi bi-whatsapp fs-5 text-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-light" />

            <div class="text-center small">&copy; 2025 MK Service — Tous droits réservés</div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    @stack('scripts')

</body>

</html>