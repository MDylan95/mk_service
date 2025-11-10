@extends('Front.layout.index')

@section('content')
<section id="accueil" class="position-relative py-5">

    {{-- Carrousel dynamique --}}
    @php
    $slides = \App\Models\Carousel::orderBy('position')->get();
    @endphp

    @if($slides->count())
    <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded-4 shadow-sm">
            @foreach($slides as $index => $slide)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $slide->image_path) }}" class="d-block w-100" style="object-fit: cover; height: 500px;" alt="Slide {{ $slide->position }}">
                    @if($slide->titre || $slide->description)
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                        <h2 class="fw-bold text-white">{{ $slide->titre ?? 'MK Service' }}</h2>
                        <p class="text-white">{{ $slide->description ?? '' }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    @endif

    {{-- Marquee --}}
    @php
    use App\Models\MessageDiffusion;
    $marqueeMessage = MessageDiffusion::getValue('marquee_message', 'MK Couture prêt à porter 📍 Treicheville Abidjan');
    @endphp

    <div class="marquee-container border-top border-bottom py-3 bg-white overflow-hidden">
        <div class="marquee-text text-dark fw-semibold" style="white-space: nowrap; display: inline-block; animation: marquee 20s linear infinite;">
            {{ $marqueeMessage }}
        </div>
    </div>

</section>

{{-- Grille d'articles --}}
<section class="image-grid-section py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            @foreach ($articles as $article)
            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 h-100 rounded-4 transition-hover animated-service">
                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->titre }}" style="object-fit: cover; height: 260px;">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2 text-dark">{{ $article->titre }}</h6>
                        <a href="{{ route('front.articles') }}" class="btn btn-sm btn-outline-dark">Voir plus</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Styles --}}
<style>
    /* Marquee animation */
    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* Cards hover effect */
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Scroll animations */
    .animated-service {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.7s ease-out;
    }

    .animated-service.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Carousel caption minimaliste */
    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        padding: 1rem;
    }
</style>

{{-- Script pour animations au scroll --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.animated-service');

        function revealOnScroll() {
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;

            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= windowHeight * 0.85) {
                    section.classList.add('visible');
                }
            });
        }

        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll();
    });
</script>
@endsection