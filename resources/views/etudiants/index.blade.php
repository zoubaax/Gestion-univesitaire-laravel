@extends('layouts.app')

@section('titre', 'Liste des Étudiants')

@section('contenu')
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                <h1 class="display-5 fw-bold text-primary mb-0">Liste des Étudiants</h1>
                <p class="text-muted mt-2">Gérez et consultez tous les étudiants inscrits</p>
            @else
                <h1 class="display-5 fw-bold text-primary mb-0">Portail Étudiant</h1>
                <p class="text-muted mt-2">Consultez les informations et résultats académiques</p>
            @endif
        </div>
        @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
        <a href="{{ route('etudiants.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Nouvel Étudiant
        </a>
        @endif
    </div>

    @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Étudiants</h6>
                            <h2 class="mb-0">{{ $total }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Moyenne Générale</h6>
                            <h2 class="mb-0">
                                {{ number_format($moyenne, 2) }}
                            </h2>
                        </div>
                        <i class="bi bi-graph-up fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Filières</h6>
                            <h2 class="mb-0">{{ \App\Models\Filiere::count() }}</h2>
                        </div>
                        <i class="bi bi-book fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Étudiants Admis</h6>
                            <h2 class="mb-0">{{ $admis }}</h2>
                            <small>{{ $total > 0 ? number_format(($admis / $total) * 100, 1) : 0 }}% de réussite</small>
                        </div>
                        <i class="bi bi-trophy fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('etudiants.index') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" id="searchInput" placeholder="Rechercher par nom, prénom..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="filiere" class="form-select" id="filiereFilter" onchange="this.form.submit()">
                            <option value="">Toutes les filières</option>
                            @php
                                $allFilieres = \App\Models\Filiere::orderBy('nom')->get();
                            @endphp
                            @foreach($allFilieres as $filiere)
                                <option value="{{ $filiere->id }}" {{ request('filiere') == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 80px">ID</th>
                            <th>Nom Complet</th>
                            <th>Filière</th>
                            <th>Moyenne</th>
                            @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                            <th class="text-end pe-4" style="width: 120px">Actions</th>
                            @else
                            <th class="text-end pe-4" style="width: 120px">Détails</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                        <tr data-nom="{{ strtolower($etudiant->nom . ' ' . $etudiant->prenom) }}" 
                            data-filiere="{{ $etudiant->filiere->id ?? '' }}" 
                            data-moyenne="{{ $etudiant->moyenne }}">
                            <td class="ps-4">
                                <span class="badge bg-secondary">#{{ $etudiant->id }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $etudiant->nom }} {{ $etudiant->prenom }}</div>
                                <small class="text-muted">ID: {{ $etudiant->id }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2">
                                    <i class="bi bi-mortarboard me-1"></i>{{ $etudiant->filiere->nom ?? 'Non définie' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $moyenneVal = $etudiant->moyenne;
                                    $badgeClass = $moyenneVal >= 10 ? 'success' : ($moyenneVal >= 8 ? 'warning' : 'danger');
                                    $icon = $moyenneVal >= 10 ? 'check-circle' : ($moyenneVal >= 8 ? 'exclamation-triangle' : 'x-circle');
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-{{ $icon }} text-{{ $badgeClass }}"></i>
                                    <span class="fw-bold {{ $moyenneVal >= 10 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($moyenneVal, 2) }}/20
                                    </span>
                                </div>
                                <div class="progress mt-1" style="height: 4px; width: 100px;">
                                    <div class="progress-bar bg-{{ $badgeClass }}" 
                                         role="progressbar" 
                                         style="width: {{ ($moyenneVal / 20) * 100 }}%" 
                                         aria-valuenow="{{ $moyenneVal }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="20">
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('etudiants.show', $etudiant->id) }}" 
                                       class="btn btn-outline-primary" 
                                       data-bs-toggle="tooltip" 
                                       title="Voir détails">
                                        <i class="bi bi-eye"></i> {{ Auth::user()->isStudent() ? 'Voir' : '' }}
                                    </a>
                                    @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                                    <a href="{{ route('etudiants.edit', $etudiant->id) }}" 
                                       class="btn btn-outline-warning"
                                       data-bs-toggle="tooltip" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $etudiant->id }}"
                                            data-bs-toggle="tooltip" 
                                            title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </div>
                                <!-- Delete Modal -->
                                @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                                <div class="modal fade" id="deleteModal{{ $etudiant->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Confirmation de suppression</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <p>Êtes-vous sûr de vouloir supprimer l'étudiant :</p>
                                                <p class="fw-bold text-danger">{{ $etudiant->nom }} {{ $etudiant->prenom }}</p>
                                                <p class="text-muted small">Cette action est irréversible.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <p class="text-muted mt-3 mb-0">Aucun étudiant trouvé dans la liste.</p>
                                @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                                <a href="{{ route('etudiants.create') }}" class="btn btn-primary mt-3">
                                    <i class="bi bi-plus-circle me-2"></i>Ajouter le premier étudiant
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination (if you have pagination) -->
    @if(method_exists($etudiants, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $etudiants->links() }}
    </div>
    @endif

@push('scripts')
<script>
    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filiereFilter = document.getElementById('filiereFilter');
        const statusFilter = document.getElementById('statusFilter');
        const tableRows = document.querySelectorAll('#studentsTable tbody tr');
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const filiereValue = filiereFilter.value;
            const statusValue = statusFilter.value;
            
            tableRows.forEach(row => {
                const nom = row.getAttribute('data-nom') || '';
                const filiere = row.getAttribute('data-filiere') || '';
                const moyenne = parseFloat(row.getAttribute('data-moyenne')) || 0;
                
                let matchesSearch = nom.includes(searchTerm) || filiere.toLowerCase().includes(searchTerm);
                let matchesFiliere = !filiereValue || filiere === filiereValue;
                let matchesStatus = true;
                
                if (statusValue === 'reussi') {
                    matchesStatus = moyenne >= 10;
                } else if (statusValue === 'echoue') {
                    matchesStatus = moyenne < 10;
                }
                
                if (matchesSearch && matchesFiliere && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        searchInput.addEventListener('keyup', filterTable);
        filiereFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush