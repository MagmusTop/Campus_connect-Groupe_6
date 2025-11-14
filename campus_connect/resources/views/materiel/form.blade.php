<form action="{{ $action }}" method="POST">
    @csrf
    @if(isset($materiel))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du matériel *</label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                       id="nom" name="nom" value="{{ old('nom', $materiel->nom ?? '') }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="materiels_category_id" class="form-label">Catégorie *</label>
                <select class="form-control @error('materiels_category_id') is-invalid @enderror" 
                        id="materiels_category_id" name="materiels_category_id" required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" 
                            {{ old('materiels_category_id', $materiel->materiels_category_id ?? '') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
                @error('materiels_category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité *</label>
                <input type="number" class="form-control @error('quantite') is-invalid @enderror" 
                       id="quantite" name="quantite" value="{{ old('quantite', $materiel->quantite ?? '') }}" min="0" required>
                @error('quantite')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" 
                  id="description" name="description" rows="4">{{ old('description', $materiel->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('materiel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <button type="submit" class="btn btn-custom">
            <i class="fas fa-save"></i> 
            {{ isset($materiel) ? 'Mettre à jour' : 'Ajouter le matériel' }}
        </button>
    </div>
</form>