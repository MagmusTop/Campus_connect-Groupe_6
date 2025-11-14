@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card hover-card-gradient">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier l'annonce</h4>
                </div>
                <div class="card-body">
                    <!-- Note développement -->
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-code me-2"></i>
                        <strong>Mode développement front-end</strong> - Le formulaire est visuel uniquement
                    </div>

                    <form id="edit-annonce-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="titre" class="form-label fw-medium">Titre de l'annonce</label>
                            <input type="text" class="form-control" 
                                   id="titre" name="titre" 
                                   value="{{ $annonce->title ?? 'Session d\'examens de Janvier 2024' }}" 
                                   placeholder="Ex: Session d'examens de Janvier 2024">
                        </div>
                        
                        <div class="mb-3">
                            <label for="categorie" class="form-label fw-medium">Catégorie</label>
                            <select class="form-select" id="categorie" name="categorie">
                                <option value="examen" {{ ($annonce->category->name ?? '') == 'examen' ? 'selected' : '' }}>Examen</option>
                                <option value="soutenance" {{ ($annonce->category->name ?? '') == 'soutenance' ? 'selected' : '' }}>Soutenance</option>
                                <option value="activite" {{ ($annonce->category->name ?? '') == 'activite' ? 'selected' : '' }}>Activité</option>
                                <option value="candidature" {{ ($annonce->category->name ?? '') == 'candidature' ? 'selected' : '' }}>Appel à candidatures</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contenu" class="form-label fw-medium">Contenu de l'annonce</label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="8" 
                                      placeholder="Détails de l'annonce...">{{ $annonce->content ?? "La session d'examens de janvier 2024 se déroulera du 15 au 30 janvier. Tous les étudiants sont priés de consulter leur emploi du temps." }}</textarea>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-custom" onclick="showPreview()">
                                <i class="fas fa-eye me-2"></i>Aperçu
                            </button>
                            <button type="button" class="btn btn-success" onclick="simulateSave()">
                                <i class="fas fa-save me-2"></i>Enregistrer (simulation)
                            </button>
                            <a href="{{ route('annonces.show', $annonce->id ?? 1) }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showPreview() {
    const titre = document.getElementById('titre').value;
    const contenu = document.getElementById('contenu').value;
    const categorie = document.getElementById('categorie').value;
    
    alert(`📋 Aperçu de l'annonce :\n\nTitre: ${titre}\nCatégorie: ${categorie}\n\nContenu:\n${contenu}\n\n(Simulation - Fonctionnalité en développement)`);
}

function simulateSave() {
    alert('✅ Modification simulée avec succès !\n\nCette fonctionnalité sera opérationnelle après l\'implémentation du backend.');
    
    // Redirection simulée
    setTimeout(() => {
        window.location.href = "{{ route('annonces.show', $annonce->id ?? 1) }}";
    }, 1500);
}

// Empêcher la soumission réelle du formulaire
document.getElementById('edit-annonce-form').addEventListener('submit', function(e) {
    e.preventDefault();
    simulateSave();
});
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
    }
</style>
@endsection