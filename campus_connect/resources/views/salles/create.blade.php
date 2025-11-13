@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Ajouter une nouvelle salle</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('salles.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom de la salle *</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capacite" class="form-label">Capacité *</label>
                                    <input type="number" class="form-control" id="capacite" name="capacite" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="localisation" class="form-label">Localisation *</label>
                            <input type="text" class="form-control" id="localisation" name="localisation" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('salles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer la salle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection