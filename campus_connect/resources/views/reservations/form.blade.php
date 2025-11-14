@props(['reservation' => null, 'action' => route('reservations.store'), 'method' => 'POST'])

<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    
    <div class="mb-3">
        <label for="type" class="form-label fw-medium">Type de réservation</label>
        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required onchange="toggleReservationType()">
            <option value="">Sélectionnez le type</option>
            <option value="salle" {{ old('type', $reservation->type ?? '') == 'salle' ? 'selected' : '' }}>Salle</option>
            <option value="materiel" {{ old('type', $reservation->type ?? '') == 'materiel' ? 'selected' : '' }}>Matériel</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Champs dynamiques pour salles -->
    <div id="salle-fields" style="display: none;">
        <div class="mb-3">
            <label for="salle_id" class="form-label fw-medium">Salle</label>
            <select class="form-select @error('salle_id') is-invalid @enderror" id="salle_id" name="salle_id">
                <option value="">Sélectionnez une salle</option>
                <option value="1" {{ old('salle_id', $reservation->salle_id ?? '') == '1' ? 'selected' : '' }}>Amphithéâtre A</option>
                <option value="2" {{ old('salle_id', $reservation->salle_id ?? '') == '2' ? 'selected' : '' }}>Salle 101</option>
                <option value="3" {{ old('salle_id', $reservation->salle_id ?? '') == '3' ? 'selected' : '' }}>Salle 102</option>
                <option value="4" {{ old('salle_id', $reservation->salle_id ?? '') == '4' ? 'selected' : '' }}>Laboratoire Informatique</option>
            </select>
            @error('salle_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Champs dynamiques pour matériel -->
    <div id="materiel-fields" style="display: none;">
        <div class="mb-3">
            <label for="materiel_id" class="form-label fw-medium">Matériel</label>
            <select class="form-select @error('materiel_id') is-invalid @enderror" id="materiel_id" name="materiel_id">
                <option value="">Sélectionnez du matériel</option>
                <option value="1" {{ old('materiel_id', $reservation->materiel_id ?? '') == '1' ? 'selected' : '' }}>Vidéo projecteur</option>
                <option value="2" {{ old('materiel_id', $reservation->materiel_id ?? '') == '2' ? 'selected' : '' }}>Ordinateur portable</option>
                <option value="3" {{ old('materiel_id', $reservation->materiel_id ?? '') == '3' ? 'selected' : '' }}>Tablette graphique</option>
                <option value="4" {{ old('materiel_id', $reservation->materiel_id ?? '') == '4' ? 'selected' : '' }}>Enceintes Bluetooth</option>
            </select>
            @error('materiel_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="date_debut" class="form-label fw-medium">Date et heure de début</label>
                <input type="datetime-local" class="form-control @error('date_debut') is-invalid @enderror" 
                       id="date_debut" name="date_debut" value="{{ old('date_debut', $reservation->date_debut ?? '') }}" required>
                @error('date_debut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="date_fin" class="form-label fw-medium">Date et heure de fin</label>
                <input type="datetime-local" class="form-control @error('date_fin') is-invalid @enderror" 
                       id="date_fin" name="date_fin" value="{{ old('date_fin', $reservation->date_fin ?? '') }}" required>
                @error('date_fin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="motif" class="form-label fw-medium">Description / Motif</label>
        <textarea class="form-control @error('motif') is-invalid @enderror" 
                  id="motif" name="motif" rows="4" 
                  placeholder="Décrivez le motif de votre réservation..." required>{{ old('motif', $reservation->motif ?? '') }}</textarea>
        @error('motif')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Retour
        </a>
        <button type="submit" class="btn btn-custom">
            <i class="fas fa-paper-plane me-1"></i>
            {{ $reservation ? 'Modifier la réservation' : 'Soumettre la réservation' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
function toggleReservationType() {
    const type = document.getElementById('type').value;
    document.getElementById('salle-fields').style.display = type === 'salle' ? 'block' : 'none';
    document.getElementById('materiel-fields').style.display = type === 'materiel' ? 'block' : 'none';
    
    // Réinitialiser les sélections quand on change de type
    if (type === 'salle') {
        document.getElementById('materiel_id').value = '';
    } else if (type === 'materiel') {
        document.getElementById('salle_id').value = '';
    }
}

// Initialiser l'état au chargement
document.addEventListener('DOMContentLoaded', function() {
    toggleReservationType();
    
    // Pré-remplir le type si déjà défini
    const currentType = document.getElementById('type').value;
    if (currentType) {
        toggleReservationType();
    }
});
</script>
@endpush