@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card hover-card-gradient">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Détails de la Réservation</h4>
                    <span class="badge bg-success">Validée</span>
                </div>
                <div class="card-body">
                    <!-- Données factices pour le développement -->
                    <!--
                        $dummyReservation = (object)[
                            'statut' => 'validée',
                            'salle_id' => 1,
                            'date_debut' => now()->addDays(1)->setHour(9),
                            'date_fin' => now()->addDays(1)->setHour(12),
                            'motif' => 'Cours de programmation avancée pour les étudiants en Master 2',
                            'salle' => (object)[
                                'nom' => 'Amphithéâtre A1',
                                'capacite' => 120,
                                'localisation' => 'Bâtiment Principal'
                            ],
                            'user' => (object)['name' => 'Professeur Dupont']
                        ];
                    -->
                    
                    <!-- Informations principales -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Type:</strong>
                        @if(isset($dummyReservation->salle))
                            <span class="text-muted">Salle</span>
                        @else
                            <span class="text-muted">Matériel</span>
                        @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Réservé par:</strong>
                            <span class="text-muted">{{ $dummyReservation->user->nom }}</span>
                        </div>
                    </div>
                    
                    <!-- Dates -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Date et heure de début:</strong>
                            <br>
                            <span class="text-muted">
                                {{ $dummyReservation->date_debut }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Date et heure de fin:</strong>
                            <br>
                            <span class="text-muted">
                                {{ $dummyReservation->date_fin }}
                            </span>
                        </div>
                    </div>
                    @if (isset($dummyReservation->salle))
                        <!-- Ressource réservée -->
                        <div class="mb-4">
                            <strong>Ressource réservée:</strong>
                            <br>
                            <span class="text-muted fs-5">
                                <i class="fas fa-building text-primary me-2"></i>
                                {{ $dummyReservation->salle->nom }}
                            </span>
                        </div>
                        
                        <!-- Détails de la salle -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <strong>Capacité:</strong>
                                <span class="text-muted">{{ $dummyReservation->salle->capacite }} places</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Localisation:</strong>
                                <span class="text-muted">{{ $dummyReservation->salle->localisation }}</span>
                            </div>
                        </div>
                    @endif

                    @if (isset($dummyReservation->equipement))
                        <!-- Ressource réservée -->
                        <div class="mb-4">
                            <strong>Ressource réservée:</strong>
                            <br>
                            <span class="text-muted fs-5">
                                <i class="fas fa-laptop text-primary me-2"></i>
                                {{ $dummyReservation->equipement->nom }}
                            </span>
                        </div>

                    @endif
                    
                    <!-- Motif -->
                    <div class="mb-4" >
                        <strong>Motif de la réservation:</strong>
                        <p class="text-muted mt-2 p-3 bg-light rounded" >
                            {{ $dummyReservation->motif }}
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reservations.index') }}" class="btn btn-custom">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux réservations
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection