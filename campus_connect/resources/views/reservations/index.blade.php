@extends('layouts.app')

@section('content')
<div class="container">

    @if (auth()->user()->isAdmin() || auth()->user()->isEnseignant())
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-calendar-check me-2"></i>Réservations</h1>
            <a href="{{ route('reservations.create') }}" class="btn btn-custom">
                <i class="fas fa-plus me-2"></i>Nouvelle réservation
            </a>
        </div>
    @endif

   <!--
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
         p--    'statut' => 'rejetée',
                'salle' => null,
                'equipement' => (object)['nom' => 'Vidéoprojecteur HD'],
                'date_debut' => now()->subDays(2)->setHour(10),
                'date_fin' => now()->subDays(2)->setHour(12),
                'motif' => 'Présentation de projet'
            ]
        ]);*/
    -->

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
        <div class="col-md-3">
            <div class="card hover-card-gradient text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $reservations->where('statut', 'valide')->count() }}</h3>
                    <p class="mb-0">Validées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card hover-card-gradient text-center">
                <div class="card-body">
                    <h3 class="text-danger">{{ $reservations->where('statut', 'rejete')->count() }}</h3>
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
            <a href="{{ route('equipements.index') }}" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center py-3">
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
                        <option value="valide">Validée</option>
                        <option value="rejete">Rejetée</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filter-type">
                        <option value="">Tous les types</option>
                        <option value="salle">Salle</option>
                        <option value="equipement">Matériel</option>
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
                                @php
                                    $type = (isset($reservation->salle_id) && $reservation->salle_id) ? 'salle' : 'equipement';
                                    $status = $reservation->statut ?? 'inconnu';
                                    $dateDebut = \Carbon\Carbon::parse($reservation->date_debut ?? now());
                                @endphp

                                <tr 
                                    data-type="{{ $type }}" 
                                    data-status="{{ strtolower($status) }}" 
                                    data-date="{{ $dateDebut->toDateString() }}"
                                >
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
                                            @if(isset($reservation->statut) && $reservation->statut === 'valide') bg-success
                                            @elseif(isset($reservation->statut) && $reservation->statut === 'rejete') bg-danger
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
                                            @if(@auth()->user()->isAdmin())
                                                <!-- Bouton Valider -->
                                                <form action="{{ route('reservations.accepte', $reservation->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="statut" value="valide">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <!-- Bouton Rejeter -->
                                                <form action="{{ route('reservations.refuse', $reservation->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="statut" value="rejete">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                        <!-- Bouton Annuler -->
                                        <form action="{{ route('reservations.destroy', $reservation->id) }}" 
                                            method="POST" 
                                            class="d-inline"
                                            onsubmit="return confirm('❌ Voulez-vous vraiment annuler cette réservation ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-ban"></i> Annuler
                                            </button>
                                        </form>
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
        const filterType   = document.getElementById('filter-type');
        const filterDate   = document.getElementById('filter-date');
        const rows         = document.querySelectorAll('tbody tr');

        function applyFilters() {
            const status = (filterStatus.value || '').toLowerCase();
            const type   = (filterType.value   || '').toLowerCase();
            const date   = filterDate.value || '';

            rows.forEach(row => {
                const rowStatus = row.dataset.status || '';
                const rowType   = row.dataset.type   || '';
                const rowDate   = row.dataset.date   || '';

                let visible = true;
                if (status && rowStatus !== status) visible = false;
                if (type && rowType !== type)       visible = false;
                if (date && rowDate !== date)       visible = false;

                row.style.display = visible ? '' : 'none';
            });
        }

        [filterStatus, filterType, filterDate].forEach(el => {
            el.addEventListener('change', applyFilters);
        });

        applyFilters(); // applique au chargement si besoin
    });
</script>
@endsection
