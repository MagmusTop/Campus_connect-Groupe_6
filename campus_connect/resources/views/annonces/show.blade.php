@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card hover-card-gradient">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Détails de l'annonce</h4>
                    <span class="badge bg-primary">Général</span>
                </div>
                <div class="card-body">
                    <!-- Données factices pour le développement -->
                    @php
                        $dummyAnnonce = (object)[
                            'title' => 'Session d\'examens de Janvier 2024',
                            'content' => "La session d'examens de janvier 2024 se déroulera du 15 au 30 janvier. Tous les étudiants sont priés de consulter leur emploi du temps.\n\nLes salles seront attribuées comme suit :\n- Bâtiment A : Licences\n- Bâtiment B : Masters\n- Bâtiment C : Doctorats\n\nEn cas d'empêchement, contacter immédiatement le service des examens.",
                            'user' => (object)['name' => 'Administration'],
                            'created_at' => now()->subDays(2)
                        ];
                    @endphp
                    
                    <div class="mb-4">
                        <h2 class="h4 mb-3">{{ $dummyAnnonce->title }}</h2>
                        <p class="text-muted mb-2">
                            <i class="fas fa-user me-2"></i>Publié par {{ $dummyAnnonce->user->name }}
                        </p>
                        <p class="text-muted">
                            <i class="fas fa-calendar me-2"></i>{{ $dummyAnnonce->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    
                    <div class="annonce-content">
                        {!! nl2br(e($dummyAnnonce->content)) !!}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('annonces.index') }}" class="btn btn-custom">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux annonces
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .annonce-content {
        line-height: 1.6;
        font-size: 1.1rem;
        white-space: pre-line;
    }
</style>
@endsection