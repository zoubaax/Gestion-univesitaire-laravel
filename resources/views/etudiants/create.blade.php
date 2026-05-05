@extends('layouts.app')

@section('titre', 'Ajouter un Étudiant')

@section('contenu')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-4">
                <a href="{{ route('etudiants.index') }}" class="btn btn-link text-decoration-none p-0 text-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-4 border-0">
                    <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-person-plus me-2"></i>Nouvel Étudiant</h4>
                    <p class="text-muted small mb-0 mt-1">Créez un profil académique et un compte de connexion</p>
                </div>
                <div class="card-body p-4 pt-0">
                    <form action="{{ route('etudiants.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nom" class="form-label fw-semibold">Nom de famille</label>
                                <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="prenom" class="form-label fw-semibold">Prénom</label>
                                <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="email" class="form-label fw-semibold">Adresse Email (pour la connexion)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirmer</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-check"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0 ps-0" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="filiere_id" class="form-label fw-semibold">Filière</label>
                                <select name="filiere_id" id="filiere_id" class="form-select @error('filiere_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Choisir une filière...</option>
                                    @foreach($filieres as $filiere)
                                        <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                            {{ $filiere->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('filiere_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 d-grid">
                            <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer l'étudiant et créer son compte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
