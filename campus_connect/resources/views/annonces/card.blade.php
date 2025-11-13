@php
    // Données sécurisées avec valeurs par défaut
    $annonceId = $annonce->id ?? 1;
    $annonceTitle = $annonce->title ?? 'Titre de l\'annonce';
    $annonceContent = $annonce->content ?? 'Contenu de l\'annonce...';
    $userName = $annonce->user->name ?? 'Administrateur';
    $createdAt = $annonce->created_at ?? now()->subDays(2);
    $categoryName = $annonce->category->name ?? 'general';
    
    // Mapping des couleurs de catégories
    $categoryColors = [
        'examen' => 'badge-category-examen',
        'soutenance' => 'badge-category-soutenance',
        'activite' => 'badge-category-activite',
        'candidature' => 'badge-category-candidature',
        'general' => 'badge-category-general',
        'maintenance' => 'badge-category-maintenance',
        'urgent' => 'badge-category-urgent',
        'Examens' => 'badge-category-examen',
        'Activités' => 'badge-category-activite',
        'Maintenance' => 'badge-category-maintenance'
    ];
    
    $categoryClass = $categoryColors[$categoryName] ?? 'badge-category-general';
@endphp

<!-- Carte verticale -->
<div class="card hover-card-gradient annonce-vertical">
    <div class="card-body">
        <div class="row align-items-start">
            <!-- Colonne principale -->
            <div class="col-md-8">
                <div class="d-flex align-items-start mb-2">
                    <span class="badge badge-category {{ $categoryClass }} me-2">{{ $categoryName }}</span>
                    <small class="text-muted">
                        <i class="fas fa-user me-1"></i>{{ $userName }}
                    </small>
                </div>
                
                <h5 class="card-title mb-2">{{ $annonceTitle }}</h5>
                <p class="card-text text-muted mb-3">
                    {{ Str::limit($annonceContent, 200) }}
                </p>
                
                <div class="d-flex align-items-center text-muted small">
                    <span class="me-3">
                        <i class="fas fa-calendar me-1"></i>
                        @if($createdAt instanceof \Carbon\Carbon)
                            {{ $createdAt->format('d/m/Y à H:i') }}
                        @else
                            {{ \Carbon\Carbon::parse($createdAt)->format('d/m/Y à H:i') }}
                        @endif
                    </span>
                </div>
            </div>
            
            <!-- Colonne actions -->
            <div class="col-md-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('annonces.show', $annonceId) }}" class="btn btn-sm btn-custom">
                        <i class="fas fa-eye me-1"></i>Voir
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary border-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('annonces.edit', $annonceId) }}">
                                    <i class="fas fa-edit me-2"></i>Modifier
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button class="dropdown-item text-danger" onclick="alert('Fonctionnalité en développement')">
                                    <i class="fas fa-trash me-2"></i>Supprimer
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .annonce-vertical {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .annonce-vertical:hover {
        transform: translateX(5px);
        border-left-color: var(--primary);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .annonce-vertical .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
    }
    
    .annonce-vertical .card-text {
        line-height: 1.5;
    }
    
    @media (max-width: 768px) {
        .annonce-vertical .col-md-4 {
            margin-top: 1rem;
        }
        
        .annonce-vertical .d-flex.justify-content-end {
            justify-content: flex-start !important;
        }
    }
</style>