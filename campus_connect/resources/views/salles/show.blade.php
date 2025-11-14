@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <h1>{{ $salle->nom }}</h1>
                        <div class="btn-group">
                            @can('update', $salle)
                                <a href="{{ route('salles.edit', $salle->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                            @endcan
                            <a href="{{ route('salles.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-map-marker-alt"></i> Localisation :</strong></p>
                            <p class="text-muted">{{ $salle->localisation }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-users"></i> Capacité :</strong></p>
                            <p class="text-muted">{{ $salle->capacite }} personnes</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p><strong>Description :</strong></p>
                        <p class="text-muted">{{ $salle->description }}</p>
                    </div>

                    @if($salle->reservations->count() > 0)
                        <div class="mt-4">
                            <h5>Réservations à venir</h5>
                            <div class="list-group">
                                @foreach($salle->reservations->where('date_debut', '>=', now())->sortBy('date_debut') as $reservation)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $reservation->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $reservation->date_debut->format('d/m/Y H:i') }} - 
                                                    {{ $reservation->date_fin->format('H:i') }}
                                                </small>
                                            </div>
                                            <span class="badge bg-{{ $reservation->statut === 'validée' ? 'success' : ($reservation->statut === 'en_attente' ? 'warning' : 'danger') }}">
                                                {{ $reservation->statut }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection