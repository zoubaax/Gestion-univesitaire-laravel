@extends('layouts.app')

@section('titre', 'Détails de l\'Étudiant')

@section('contenu')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('etudiants.index') }}" class="btn btn-link text-decoration-none p-0 text-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: 700;">
                            {{ substr($etudiant->prenom, 0, 1) }}{{ substr($etudiant->nom, 0, 1) }}
                        </div>
                        <h1 class="h2 mb-1 fw-bold">{{ $etudiant->prenom }} {{ $etudiant->nom }}</h1>
                        <p class="text-muted">Profil Étudiant #{{ $etudiant->id }}</p>
                    </div>

                    <div class="row g-4">
                        @php
                            $moyenneCalculée = $etudiant->notes->count() > 0 ? $etudiant->notes->avg('note') : 0;
                            $fields = [
                                'ID' => $etudiant->id,
                                'Nom' => $etudiant->nom,
                                'Prénom' => $etudiant->prenom,
                                'Email' => $etudiant->email,
                                'Filière' => $etudiant->filiere->nom ?? 'N/A',
                                'Moyenne (Rel.)' => $moyenneCalculée
                            ];
                        @endphp

                        @foreach($fields as $label => $valeur)
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light bg-opacity-50">
                                <label class="small text-muted text-uppercase fw-bold mb-1">{{ $label }}</label>
                                <div class="h5 mb-0 fw-semibold">
                                    @if($label == 'Moyenne (Rel.)')
                                        <span class="{{ $valeur >= 10 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($valeur, 2) }}/20
                                        </span>
                                    @elseif($label == 'Filière')
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                            {{ $valeur }}
                                        </span>
                                    @else
                                        {{ $valeur }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                    <div class="mt-5 d-flex gap-2">
                        <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning flex-grow-1 py-3 fw-bold">
                            <i class="bi bi-pencil me-2"></i>Modifier le profil
                        </a>
                        <button class="btn btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-journal-text me-2"></i>Relevé de Notes</h5>
                    @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                    <a href="{{ route('notes.create', $etudiant->id) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-lg me-1"></i>Ajouter une note
                    </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Matière</th>
                                    <th>Semestre</th>
                                    <th>Note</th>
                                    <th class="text-end pe-4">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiant->notes as $note)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $note->matiere }}</td>
                                    <td>{{ $note->semestre }}</td>
                                    <td><span class="fw-bold">{{ number_format($note->note, 2) }}</span>/20</td>
                                    <td class="text-end pe-4">
                                        @if($note->note >= 10)
                                            <span class="badge bg-success">Validé</span>
                                        @else
                                            <span class="badge bg-danger">Non validé</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Aucune note enregistrée pour cet étudiant.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal (Simplified for show page) -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title">Attention</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-1">Voulez-vous vraiment supprimer cet étudiant ?</p>
                <p class="fw-bold text-danger">{{ $etudiant->nom }} {{ $etudiant->prenom }}</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

