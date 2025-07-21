@extends('back.dashboard')

@section('content')

<div class="alert alert-primary text-center fs-5 fw-semibold py-3 rounded-3 shadow-sm" role="alert">
    👋 Bonjour, <span class="text-primary">{{ auth()->user()?->name ?? 'Invité' }}</span> ! Heureux de vous revoir. 🎉
</div>

<div class="row g-4">

    <!-- Articles en ligne -->
    <div class="col-xl-4 col-md-6">
        <div class="card shadow-sm border-start border-primary rounded-3 h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-primary text-uppercase fw-bold mb-2">Articles en ligne</h6>
                    <h3 class="fw-bold text-gray-900">{{ $articlesCount }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-newspaper fa-3x text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages non lus -->
    <div class="col-xl-4 col-md-6">
        <div class="card shadow-sm border-start border-warning rounded-3 h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-warning text-uppercase fw-bold mb-2">Messages</h6>
                    <h3 class="fw-bold text-gray-900">{{ $messagesNonLusCount }}</h3>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-envelope fa-3x text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Commandes non lues -->
    <div class="col-xl-4 col-md-6">
        <div class="card shadow-sm border-start border-success rounded-3 h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-success text-uppercase fw-bold mb-2">Commandes</h6>
                    <h3 class="fw-bold text-gray-900">{{ $commandesNonLuesCount }}</h3>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-envelope-open fa-3x text-success"></i>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection