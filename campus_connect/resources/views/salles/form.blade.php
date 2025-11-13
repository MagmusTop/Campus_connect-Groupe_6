<form action="{{ $action }}" method="POST">
    @csrf
    @if(isset($salle))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la salle *</label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                       id="nom" name="nom" value="{{ old('nom', $salle->nom ?? '') }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="capacite" class="form-label">Capacité *</label>
                <input type="number" class="form-control @error('capacite') is-invalid @enderror" 
                       id="capacite" name="capacite" value="{{ old('capacite', $salle->capacite ?? '') }}" min="1" required>
                @error('capacite')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="localisation" class="form-label">Localisation *</label>
        <input type="text" class="form-control @error('localisation') is-invalid @enderror" 
               id="localisation" name="localisation" value="{{ old('localisation', $salle->localisation ?? '') }}" required>
        @error('localisation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" 
                  id="description" name="description" rows="4">{{ old('description', $salle->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('salles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <button type="submit" class="btn btn-custom">
            <i class="fas fa-save"></i> 
            {{ isset($salle) ? 'Mettre à jour' : 'Créer la salle' }}
        </button>
    </div>
</form>