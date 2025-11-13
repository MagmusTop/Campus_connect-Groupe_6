@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>Bienvenu</h1>
    <p>Votre portail universitaire moderne et minimaliste</p>
</div>

<div class="container mt-5">
    <div class="row g-4 align-center-cards">
        <div class="col-md-4">
            <div class="card hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-bullhorn fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Annonces</h5>
                    <p class="card-text">Consultez les dernières annonces de l'université</p>
                    <a href="{{ route('annonces.index') }}" class="btn btn-custom">Voir les annonces</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">Réservations</h5>
                    <p class="card-text">Réservez des salles ou du matériel</p>
                    <a href="{{ route('reservations.index') }}" class="btn btn-custom">Faire une réservation</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-building fa-3x mb-3 text-info"></i>
                    <h5 class="card-title">Salles</h5>
                    <p class="card-text">Consultez la disponibilité des salles</p>
                    <a href="{{ route('salles.index') }}" class="btn btn-custom">Voir les salles</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection