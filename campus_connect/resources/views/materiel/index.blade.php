@extends('layouts.app')

@section('content')
<div class="container">
    <!-- En-tête avec actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="fas fa-laptop me-2"></i>Matériel</h1>
            <p class="text-muted mb-0">Gérez le matériel disponible sur le campus</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('reservations.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-calendar-plus me-1"></i>Réserver
            </a>
            
            <a href="{{ route('materiel.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Ajouter
            </a>
        </div>
    </div>

    <!-- Messages de statut -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Navigation rapide -->
    <div class="row mb-4">
        <div class="col-md-4">
            <a href="{{ route('reservations.index') }}" class="card text-decoration-none h-100 card-hover">
                <div class="card-body text-center p-3">
                    <i class="fas fa-calendar-check text-primary fa-2x mb-2"></i>
                    <h6 class="card-title mb-1">Mes Réservations</h6>
                    <small class="text-muted">Voir mes réservations</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('salles.index') }}" class="card text-decoration-none h-100 card-hover">
                <div class="card-body text-center p-3">
                    <i class="fas fa-door-open text-success fa-2x mb-2"></i>
                    <h6 class="card-title mb-1">Salles</h6>
                    <small class="text-muted">Explorer les salles</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card bg-light h-100">
                <div class="card-body text-center p-3">
                    <i class="fas fa-tools text-info fa-2x mb-2"></i>
                    <h6 class="card-title mb-1">{{ $materiels->count() }} Équipements</h6>
                    <small class="text-muted">Total disponible</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste du matériel -->
    <div class="row">
        @foreach($materiels as $materiel)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $materiel->nom }}</h5>
                            <span class="badge {{ $materiel->quantite > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $materiel->quantite }} dispo
                            </span>
                        </div>
                        
                        <p class="card-text text-muted mb-2">
                            <i class="fas fa-tag me-2"></i>{{ $materiel->categorie->name ?? 'Non catégorisé' }}
                        </p>
                        
                        <p class="card-text small">{{ Str::limit($materiel->description, 120) }}</p>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('materiel.show', $materiel->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>Détails
                            </a>
                            @if($materiel->quantite > 0)
                                <a href="{{ route('reservations.create') }}" class="btn btn-success btn-sm flex-fill">
                                    <i class="fas fa-calendar-plus me-1"></i>Réserver
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-sm flex-fill" disabled>
                                    <i class="fas fa-times me-1"></i>Indisponible
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($materiels->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-laptop fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Aucun matériel disponible</h4>
            <p class="text-muted mb-4">Commencez par ajouter votre premier équipement</p>
            <a href="{{ route('materiel.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Ajouter du matériel
            </a>
        </div>
    @endif
</div>

<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid var(--border);
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn-group .btn {
    border-radius: 6px;
}

.card .btn-sm {
    padding: 0.375rem 0.5rem;
    font-size: 0.8rem;
}

.flex-fill {
    flex: 1;
    min-width: 0;
}

/* Adaptation pour le thème sombre */
[data-bs-theme="dark"] .card {
    background: var(--card-bg);
    border-color: var(--border);
}

[data-bs-theme="dark"] .bg-light {
    background: rgba(255,255,255,0.1) !important;
    color: var(--text);
}

[data-bs-theme="dark"] .text-muted {
    color: #9ca3af !important;
}

.alert {
    border: none;
    border-radius: 8px;
}

.badge.bg-success {
    background-color: #10b981 !important;
}

.badge.bg-danger {
    background-color: #ef4444 !important;
}
</style>
@endsection