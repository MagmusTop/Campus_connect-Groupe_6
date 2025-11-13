@extends('layouts.app')

@section('title', 'Nouvelle réservation')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Nouvelle réservation</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="type" class="form-label fw-medium">Type de réservation</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required onchange="toggleReservationType()">
                            <option value="">Sélectionnez le type</option>
                            <option value="salle" {{ old('type') == 'salle' ? 'selected' : '' }}>Salle</option>
                            <option value="materiel" {{ old('type') == 'materiel' ? 'selected' : '' }}>Matériel</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Champs dynamiques pour salles -->
                    <div id="salle-fields" style="display: none;">
                        <div class="mb-3">
                            <label for="salle_id" class="form-label fw-medium">Salle</label>
                            <select class="form-select" id="salle_id" name="salle_id">
                                <option value="">Sélectionnez une salle</option>
                                <option value="1">Amphithéâtre A</option>
                                <option value="2">Salle 101</option>
                                <option value="3">Salle 102</option>
                                <option value="4">Laboratoire Informatique</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champs dynamiques pour matériel -->
                    <div id="materiel-fields" style="display: none;">
                        <div class="mb-3">
                            <label for="materiel_id" class="form-label fw-medium">Matériel</label>
                            <select class="form-select" id="materiel_id" name="materiel_id">
                                <option value="">Sélectionnez du matériel</option>
                                <option value="1">Vidéo projecteur</option>
                                <option value="2">Ordinateur portable</option>
                                <option value="3">Tablette graphique</option>
                                <option value="4">Enceintes Bluetooth</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label fw-medium">Date et heure de début</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label fw-medium">Date et heure de fin</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Description / Motif</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Décrivez le motif de votre réservation..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Soumettre la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleReservationType() {
    const type = document.getElementById('type').value;
    document.getElementById('salle-fields').style.display = type === 'salle' ? 'block' : 'none';
    document.getElementById('materiel-fields').style.display = type === 'materiel' ? 'block' : 'none';
}

// Initialiser l'état au chargement
document.addEventListener('DOMContentLoaded', function() {
    toggleReservationType();
});
</script>
@endpush