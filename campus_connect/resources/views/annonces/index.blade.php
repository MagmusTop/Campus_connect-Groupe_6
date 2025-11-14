@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-bullhorn me-2"></i>Annonces</h1>
        <a href="{{ route('annonces.create') }}" class="btn btn-custom">
            <i class="fas fa-plus me-2"></i>Nouvelle annonce
        </a>
    </div>

    <!-- Filtres et recherche -->
    <div class=" mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Rechercher une annonce...">
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Toutes les catégories</option>
                        <option value="examen">Examen</option>
                        <option value="soutenance">Soutenance</option>
                        <option value="activite">Activité</option>
                        <option value="candidature">Appel à candidatures</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-custom w-100">
                        <i class="fas fa-filter me-2"></i>Filtrer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste verticale des annonces -->
    <div class="row">
        <div class="col-12">
            @if(isset($annonces) && $annonces->count() > 0)
                <div class="annonces-list">
                    @foreach($annonces as $annonce)
                        @include('annonces.card', ['annonce' => $annonce])
                    @endforeach
                </div>
            @else
                <!-- État vide -->
                <div class="card hover-card-gradient">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Aucune annonce pour le moment</h4>
                        <p class="text-muted mb-4">Soyez le premier à publier une annonce !</p>
                        <a href="{{ route('annonces.create') }}" class="btn btn-custom">
                            <i class="fas fa-plus me-2"></i>Créer une annonce
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- NOTE PAGINATION - À IMPLÉMENTER PLUS TARD -->
    @if(isset($annonces) && $annonces->count() > 6)
        <div class="alert alert-info mt-4 text-center">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Pagination</strong> - Fonctionnalité à implémenter côté backend
        </div>
    @endif
</div>

<style>
    .annonces-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    /* Couleurs des catégories */
    .badge-category-examen {
        background-color: #dc3545 !important;
        color: white !important;
    }
    
    .badge-category-soutenance {
        background-color: #0dcaf0 !important;
        color: white !important;
    }
    
    .badge-category-activite {
        background-color: #198754 !important;
        color: white !important;
    }
    
    .badge-category-candidature {
        background-color: #ffc107 !important;
        color: black !important;
    }
    
    .badge-category-general {
        background-color: #6c757d !important;
        color: white !important;
    }
    
    .badge-category-maintenance {
        background-color: #6f42c1 !important;
        color: white !important;
    }
    
    .badge-category-urgent {
        background-color: #fd7e14 !important;
        color: white !important;
    }
    
    .badge-category {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.4em 0.8em;
    }
</style>
@endsection