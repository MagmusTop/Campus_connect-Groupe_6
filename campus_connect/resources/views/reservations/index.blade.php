@extends('layouts.app')

@section('content')
<div class="container reservations-page">
    <!-- En-tête -->
    <div class="reservations-page-header">
        <div>
            <h1><i class="fas fa-calendar-check me-2"></i>Mes Réservations</h1>
            <p class="reservations-page-subtitle">Gérez vos réservations en un clin d'œil</p>
        </div>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau
        </a>
    </div>

    @php
        $reservations = collect([
            (object)[
                'id' => 1,
                'statut' => 'validée',
                'salle' => (object)['nom' => 'Amphithéâtre A1'],
                'equipement' => null,
                'date_debut' => now()->addDays(1)->setHour(9),
                'date_fin' => now()->addDays(1)->setHour(12),
                'motif' => 'Cours de programmation avancée'
            ],
            (object)[
                'id' => 2,
                'statut' => 'en_attente', 
                'salle' => (object)['nom' => 'Salle B203'],
                'equipement' => null,
                'date_debut' => now()->addDays(3)->setHour(14),
                'date_fin' => now()->addDays(3)->setHour(16),
                'motif' => 'Réunion de projet étudiant'
            ],
            (object)[
                'id' => 3,
                'statut' => 'rejetée',
                'salle' => null,
                'equipement' => (object)['nom' => 'Vidéoprojecteur HD'],
                'date_debut' => now()->subDays(2)->setHour(10),
                'date_fin' => now()->subDays(2)->setHour(12),
                'motif' => 'Présentation de projet'
            ]
        ]);
    @endphp

    <!-- Statistiques -->
    <div class="reservations-stats-grid">
        <div class="reservations-stat-card">
            <div class="reservations-stat-icon reservations-total">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="reservations-stat-content">
                <h3>{{ $reservations->count() }}</h3>
                <p>Total</p>
            </div>
        </div>
        <div class="reservations-stat-card">
            <div class="reservations-stat-icon reservations-confirmed">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="reservations-stat-content">
                <h3>{{ $reservations->where('statut', 'validée')->count() }}</h3>
                <p>Confirmées</p>
            </div>
        </div>
        <div class="reservations-stat-card">
            <div class="reservations-stat-icon reservations-pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="reservations-stat-content">
                <h3>{{ $reservations->where('statut', 'en_attente')->count() }}</h3>
                <p>En attente</p>
            </div>
        </div>
        <div class="reservations-stat-card">
            <div class="reservations-stat-icon reservations-rejected">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="reservations-stat-content">
                <h3>{{ $reservations->where('statut', 'rejetée')->count() }}</h3>
                <p>Rejetées</p>
            </div>
        </div>
    </div>

    <!-- Navigation rapide -->
    <div class="reservations-quick-nav">
        <div class="reservations-nav-grid">
            <a href="{{ route('salles.index') }}" class="reservations-nav-item">
                <div class="reservations-nav-icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="reservations-nav-content">
                    <h4>Salles</h4>
                    <p>Explorer les salles disponibles</p>
                </div>
                <i class="fas fa-chevron-right reservations-arrow"></i>
            </a>
            <a href="{{ route('materiel.index') }}" class="reservations-nav-item">
                <div class="reservations-nav-icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <div class="reservations-nav-content">
                    <h4>Matériel</h4>
                    <p>Découvrir le matériel</p>
                </div>
                <i class="fas fa-chevron-right reservations-arrow"></i>
            </a>
        </div>
    </div>

    <!-- Liste des réservations -->
    <div class="reservations-section">
        <div class="reservations-section-header">
            <h3>Dernières réservations</h3>
        </div>

        @if($reservations->count() > 0)
            <div class="reservations-list">
                @foreach($reservations as $reservation)
                    <div class="reservations-item reservations-{{ $reservation->statut }}">
                        <div class="reservations-header">
                            <div class="reservations-resource">
                                <div class="reservations-resource-icon">
                                    <i class="fas fa-{{ $reservation->salle ? 'building' : 'laptop' }}"></i>
                                </div>
                                <div class="reservations-resource-info">
                                    <h4>{{ $reservation->salle->nom ?? $reservation->equipement->nom }}</h4>
                                    <p>{{ $reservation->motif }}</p>
                                </div>
                            </div>
                            <div class="reservations-status">
                                <span class="reservations-status-badge reservations-{{ $reservation->statut }}">
                                    {{ $reservation->statut }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="reservations-time">
                            <i class="fas fa-clock me-2"></i>
                            <span>{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y • H:i') }} - {{ \Carbon\Carbon::parse($reservation->date_fin)->format('H:i') }}</span>
                        </div>

                        <div class="reservations-actions">
                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                                Voir
                            </a>
                            @if($reservation->statut === 'en_attente')
                                <button class="btn btn-sm btn-outline-danger" onclick="cancelReservation({{ $reservation->id }})">
                                    <i class="fas fa-times"></i>
                                    Annuler
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- État vide -->
            <div class="reservations-empty-state">
                <div class="reservations-empty-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h3>Aucune réservation</h3>
                <p>Commencez par créer votre première réservation</p>
                <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Créer une réservation
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function cancelReservation(id) {
    if(confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
        alert('Réservation #' + id + ' annulée (simulation)');
    }
}
</script>

@endsection