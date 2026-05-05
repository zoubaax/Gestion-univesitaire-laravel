@extends('layouts.app')

@section('titre', 'Modifier l\'Étudiant')

@section('contenu')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('etudiants.show', $etudiant->id) }}" class="btn btn-link text-decoration-none p-0 text-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Retour au profil
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h4 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Modifier l'Étudiant</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label fw-semibold">Nom</label>
                                <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $etudiant->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="prenom" class="form-label fw-semibold">Prénom</label>
                                <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $etudiant->prenom) }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="email" class="form-label fw-semibold">Adresse Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $etudiant->email) }}" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="filiere_id" class="form-label fw-semibold">Filière</label>
                                <select name="filiere_id" id="filiere_id" class="form-select @error('filiere_id') is-invalid @enderror" required>
                                    @foreach($filieres as $filiere)
                                        <option value="{{ $filiere->id }}" {{ old('filiere_id', $etudiant->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                            {{ $filiere->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('filiere_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="moyenne" class="form-label fw-semibold">Moyenne</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="moyenne" id="moyenne" class="form-control @error('moyenne') is-invalid @enderror" value="{{ old('moyenne', $etudiant->moyenne) }}" min="0" max="20">
                                    <span class="input-group-text">/ 20</span>
                                </div>
                                @error('moyenne')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-grow-1 py-3 fw-bold text-dark">
                                <i class="bi bi-check-circle me-2"></i>Mettre à jour
                            </button>
                            <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary px-4 py-3">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
