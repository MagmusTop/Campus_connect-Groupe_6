@extends('layouts.app')

@section('content')

 <style>
    /* Container */
    .dropdown-search {
        position: relative;
        width: 100%;
    }

    /* Input */
    .search-input {
        width: 100%;
        padding: 10px 35px 10px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
        cursor: pointer;
    }
    .search-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    /* Arrow */
    .dropdown-arrow {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #666;
        transition: transform 0.3s;
    }
    .dropdown-arrow.open {
        transform: translateY(-50%) rotate(180deg);
    }

    /* List */
    .dropdown-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 4px 4px;
        max-height: 250px;
        overflow-y: auto;
        display: none;
        z-index: 1000;
        background-color: #212529;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .dropdown-list.show {
        display: block;
    }

    /* Items */
    .dropdown-item {
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .dropdown-item:hover {
        background-color: #2067d1ff;
        color: #78adfcff;
    }
    .dropdown-item.selected {
        background-color: #78adfcff;
        color: #007bff;
    }
    .dropdown-item.create-new {
        background-color: #f0f8ff;
        color: #007bff;
        font-weight: bold;
        border-top: 2px solid #007bff;
    }
    .dropdown-item.create-new:hover {
        background-color: #e0f0ff;
    }

    /* No results */
    .no-results {
        padding: 10px;
        text-align: center;
        color: #999;
        font-style: italic;
    }

    /* Hidden select sent to server */
    .hidden-select {
        display: none;
    }
</style>
<form action="{{ route('salles.update', $salle) }}" method="POST">
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