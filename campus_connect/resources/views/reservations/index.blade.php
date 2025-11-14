@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-check me-2"></i>Réservations</h1>
        <a href="{{ route('reservations.create') }}" class="btn btn-custom">
            <i class="fas fa-plus me-2"></i>Nouvelle réservation
        </a>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card hover-card-gradient text-center">
                <div class="card-body">
                    <h3 class="text-primary">{{ $reservations->where('statut', 'en_attente')->count() }}</h3>
                    <p class="mb-0">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card hover-card-gradient text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $reservations->where('statut', 'validée')->count() }}</h3>
                    <p class="mb-0">Validées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card hover-card-gradient text-center">
                <div class="card-body">
                    <h3 class="text-danger">{{ $reservations->where('statut', 'rejetée')->count() }}</h3>
                    <p class="mb-0">Rejetées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card hover-card-gradient text-center">
                <div class="card-body">
                    <h3 class="text-info">{{ $reservations->count() }}</h3>
                    <p class="mb-0">Total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔵 Accès rapide -->
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('salles.index') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center py-3">
                <i class="fas fa-door-open me-2"></i> Voir les salles
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('materiel.index') }}" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center py-3">
                <i class="fas fa-laptop me-2"></i> Voir le matériel
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <select class="form-select" id="filter-status">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="validée">Validée</option>
                        <option value="rejetée">Rejetée</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filter-type">
                        <option value="">Tous les types</option>
                        <option value="salle">Salle</option>
                        <option value="materiel">Matériel</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" id="filter-date">
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des réservations -->
    <div class="card hover-card-gradient">
        <div class="card-header">
            <h5 class="mb-0">Mes réservations</h5>
        </div>
        <div class="card-body">
            @if(isset($reservations) && $reservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Ressource</th>
                                <th>Date et heure</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>
                                        @if(isset($reservation->salle_id) && $reservation->salle_id)
                                            <i class="fas fa-building text-primary me-2"></i>Salle
                                        @else
                                            <i class="fas fa-laptop text-info me-2"></i>Matériel
                                        @endif
                                    </td>
                                    <td>
                                        {{ $reservation->salle->nom ?? $reservation->equipement->nom ?? 'Non défini' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($reservation->date_debut ?? now())->format('d/m/Y H:i') }}<br>
                                        <small class="text-muted">
                                            au {{ \Carbon\Carbon::parse($reservation->date_fin ?? now())->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if(isset($reservation->statut) && $reservation->statut === 'validée') bg-success
                                            @elseif(isset($reservation->statut) && $reservation->statut === 'rejetée') bg-danger
                                            @else bg-warning @endif">
                                            {{ ucfirst($reservation->statut ?? 'inconnu') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(isset($reservation->id))
                                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-custom">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(isset($reservation->statut) && $reservation->statut === 'en_attente')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune réservation</h4>
                    <p class="text-muted">Créez votre première réservation !</p>
                    <a href="{{ route('reservations.create') }}" class="btn btn-custom">
                        <i class="fas fa-plus me-2"></i>Nouvelle réservation
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterStatus = document.getElementById('filter-status');
    const filterType = document.getElementById('filter-type');
    const filterDate = document.getElementById('filter-date');
    
    [filterStatus, filterType, filterDate].forEach(filter => {
        filter.addEventListener('change', function() {
            console.log('Filtre appliqué');
        });
    });
});
</script>
@endsection
