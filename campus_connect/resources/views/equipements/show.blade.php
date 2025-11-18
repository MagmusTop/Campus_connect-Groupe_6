@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-laptop me-2"></i>{{ $equipement->nom }}</h4>
                    <a href="{{ route('equipements.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Retour
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag me-2"></i>Catégorie :</strong></p>
                            <p class="text-muted">{{ $equipement->categorie->nom ?? 'Non catégorisé' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-boxes me-2"></i>Quantité disponible :</strong></p>
                            <p class="text-muted">{{ $equipement->quantite }} unité(s)</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p><strong>Description :</strong></p>
                        <p class="text-muted">{{ $equipement->description }}</p>
                    </div>

                    @if($equipement->quantite > 0)
                        <div class="text-center mt-4">
                            <a href="{{ route('reservations.create') }}" class="btn btn-success">
                                <i class="fas fa-calendar-plus me-2"></i>Réserver ce matériel
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection