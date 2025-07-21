@extends('Front.layout.index')

@section('content')
<section id="accueil" class="position-relative py-5">

    {{-- Carrousel dynamique avec images de la BDD --}}
    @php
    $slides = \App\Models\Carousel::orderBy('position')->get();
    @endphp

    @if($slides->count())
    <div id="heroCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($slides as $index => $slide)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $slide->image_path) }}" class="d-block w-100 h-100" alt="Slide {{ $slide->position }}" style="object-fit: cover;">
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

    <div class="marquee-container border-top border-bottom py-3 bg-light overflow-hidden">
        <div class="marquee-text">
            {{ $marqueeMessage }}
        </div>
    </div>

</section>

{{-- Grille d'articles --}}
<section class="image-grid-section py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            @foreach ($articles as $article)
            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 h-100">
                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->titre }}" style="object-fit: cover; height: 260px;">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2">{{ $article->titre }}</h6>
                        <a href="{{ route('front.articles') }}" class="btn btn-sm btn-outline-dark">Voir plus</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSection = document.querySelector('.animated-service');

        function revealOnScroll() {
            const rect = serviceSection.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;

            if (rect.top <= windowHeight * 0.85) {
                serviceSection.classList.add('visible');
                window.removeEventListener('scroll', revealOnScroll);
            }
        }

        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll(); // check immediately on load
    });
</script>
@endsection