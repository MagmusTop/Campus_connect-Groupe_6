@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Ajouter du matériel</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('materiel.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom du matériel *</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="materiels_category_id" class="form-label">Catégorie *</label>
                                    <select class="form-control" id="materiels_category_id" name="materiels_category_id" required>
                                        <option value="">Sélectionnez une catégorie</option>
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantite" class="form-label">Quantité *</label>
                                    <input type="number" class="form-control" id="quantite" name="quantite" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('materiel.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le matériel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection