@extends('layouts.app')

@section('titre', 'Ajouter une Note')

@section('contenu')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-4">
                <a href="{{ route('etudiants.show', $etudiant->id) }}" class="btn btn-link text-decoration-none p-0 text-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Retour au profil de {{ $etudiant->nom }}
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h4 class="mb-0 fw-bold text-success"><i class="bi bi-plus-circle me-2"></i>Nouvelle Note</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 bg-info bg-opacity-10 text-info small mb-4">
                        Vous ajoutez une note pour l'étudiant : <strong>{{ $etudiant->nom }} {{ $etudiant->prenom }}</strong>
                    </div>

                    <form action="{{ route('notes.store', $etudiant->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="matiere" class="form-label fw-semibold">Matière</label>
                            <input type="text" name="matiere" id="matiere" class="form-control @error('matiere') is-invalid @enderror" value="{{ old('matiere') }}" placeholder="Ex: Mathématiques, PHP, etc." required>
                            @error('matiere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="note" class="form-label fw-semibold">Note</label>
                                <div class="input-group">
                                    <input type="number" step="0.25" name="note" id="note" class="form-control @error('note') is-invalid @enderror" value="{{ old('note') }}" min="0" max="20" required>
                                    <span class="input-group-text">/ 20</span>
                                </div>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="semestre" class="form-label fw-semibold">Semestre</label>
                                <select name="semestre" id="semestre" class="form-select @error('semestre') is-invalid @enderror" required>
                                    <option value="" disabled selected>Choisir...</option>
                                    <option value="S1" {{ old('semestre') == 'S1' ? 'selected' : '' }}>Semestre 1 (S1)</option>
                                    <option value="S2" {{ old('semestre') == 'S2' ? 'selected' : '' }}>Semestre 2 (S2)</option>
                                </select>
                                @error('semestre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 d-grid">
                            <button type="submit" class="btn btn-success py-3 fw-bold">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer la note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
