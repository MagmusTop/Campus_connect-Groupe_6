@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Debug: Vérification des routes -->
    @php
        $canCreate = auth()->check(); // Temporairement true pour tester
    @endphp

    <!-- En-tête avec actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="fas fa-door-open me-2"></i>Salles</h1>
            <p class="text-muted mb-0">Gérez les salles disponibles sur le campus</p>
        </div>
        @if (auth()->user()->isAdmin() || auth()->user()->isEnseignant())
            <div class="btn-group">
                <a href="{{ route('reservations.create') }}" class="btn btn-outline-primary">
                    <i class="fas fa-calendar-plus me-1"></i>Réserver
                </a>
                @if (auth()->user()->isAdmin())
                <!-- Bouton Ajouter toujours visible pour test -->
                <a href="{{ route('salles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Ajouter
                </a>
                @endif
            </div>
        @endif
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
            <a href="{{ route('equipements.index') }}" class="card text-decoration-none h-100 card-hover">
                <div class="card-body text-center p-3">
                    <i class="fas fa-laptop text-info fa-2x mb-2"></i>
                    <h6 class="card-title mb-1">Matériel</h6>
                    <small class="text-muted">Explorer le matériel</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card bg-light h-100">
                <div class="card-body text-center p-3">
                    <i class="fas fa-building text-success fa-2x mb-2"></i>
                    <h6 class="card-title mb-1">{{ $salles->count() }} Salles</h6>
                    <small class="text-muted">Total disponible</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des salles -->
    <div class="row">
        @foreach($salles as $salle)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $salle->nom }}</h5>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-users me-1"></i>{{ $salle->capacite }}
                            </span>
                        </div>
                        
                        <p class="card-text text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $salle->localisation }}
                        </p>
                        
                        <p class="card-text small">{{ Str::limit($salle->description, 120) }}</p>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('salles.show', $salle->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>Détails
                            </a>
                            @if (auth()->user()->isAdmin() || auth()->user()->isEnseignant())
                                <a href="{{ route('reservations.create') }}" class="btn btn-success btn-sm flex-fill">
                                    <i class="fas fa-calendar-plus me-1"></i>Réserver
                                </a>
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('salles.edit', $salle->id) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($salles->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-door-open fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Aucune salle disponible</h4>
            <p class="text-muted mb-4">Commencez par ajouter votre première salle</p>
            <a href="{{ route('salles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Ajouter une salle
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
</style>

<script>
// Debug: Vérification dans la console
console.log('Route salles.create:', '{{ route("salles.create") }}');
console.log('Route salles.store:', '{{ route("salles.store") }}');
</script>
@endsection