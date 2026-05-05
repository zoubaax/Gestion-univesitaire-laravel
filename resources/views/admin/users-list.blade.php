@extends('layouts.app')

@section('titre', 'Liste des Utilisateurs')

@section('contenu')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="bi bi-list-ul me-2"></i>Liste des Utilisateurs
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Créé le</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-success">Admin</span>
                                    @elseif($user->role === 'professor')
                                        <span class="badge bg-info">Professeur</span>
                                    @else
                                        <span class="badge bg-warning">Étudiant</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Aucun utilisateur trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Retour au tableau de bord
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
