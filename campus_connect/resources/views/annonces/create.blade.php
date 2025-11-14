@extends('layouts.app')

@section('title', 'Publier une annonce')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Publier une nouvelle annonce</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('annonces.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="titre" class="form-label fw-medium">Titre de l'annonce</label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                               id="titre" name="titre" value="{{ old('titre') }}" 
                               placeholder="Ex: Session d'examens de Janvier 2024" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="categorie" class="form-label fw-medium">Catégorie</label>
                        <select class="form-select @error('categorie') is-invalid @enderror" id="categorie" name="categorie" required>
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="examen" {{ old('categorie') == 'examen' ? 'selected' : '' }}>Examen</option>
                            <option value="soutenance" {{ old('categorie') == 'soutenance' ? 'selected' : '' }}>Soutenance</option>
                            <option value="activite" {{ old('categorie') == 'activite' ? 'selected' : '' }}>Activité universitaire</option>
                            <option value="candidature" {{ old('categorie') == 'candidature' ? 'selected' : '' }}>Appel à candidatures</option>
                        </select>
                        @error('categorie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contenu" class="form-label fw-medium">Contenu de l'annonce</label>
                        <textarea class="form-control @error('contenu') is-invalid @enderror" 
                                  id="contenu" name="contenu" rows="8" 
                                  placeholder="Détails de l'annonce..." required>{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('annonces.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Publier l'annonce
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection