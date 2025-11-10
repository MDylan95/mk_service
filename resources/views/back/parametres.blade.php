@extends('back.dashboard')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Paramètres</h1>

    <div class="row">
        <!-- Carte : Images d'accueil -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <i class="fas fa-image fa-2x mb-2 text-primary"></i>
                        <h5 class="card-title">Images d'accueil</h5>
                    </div>
                    <a href="{{ route('admin.parametres.carrousel') }}" class="btn btn-primary btn-sm mt-3">
                        Gérer
                    </a>
                </div>
            </div>
        </div>

        <!-- Carte : Message de diffusion -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <i class="fas fa-bullhorn fa-2x mb-2 text-success"></i>
                        <h5 class="card-title">Message de diffusion</h5>
                    </div>
                    <a href="{{ route('admin.message_diffusion.edit') }}" class="btn btn-success btn-sm mt-3">
                        Modifier
                    </a>
                </div>
            </div>
        </div>

        <!-- Carte : Paramètres du compte -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <i class="fas fa-user-cog fa-2x mb-2 text-info"></i>
                        <h5 class="card-title">Paramètres du compte</h5>
                    </div>
                    <a href="{{ route('admin.parametres.compte') }}" class="btn btn-info btn-sm mt-3">
                        Gérer
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection