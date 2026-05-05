@extends('layouts.app')

@section('titre', 'Tableau de bord Admin')

@section('contenu')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord Administration
        </h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-people-fill text-primary fs-1 mb-2"></i>
                <h3 class="h4 mb-1">{{ $totalUsers }}</h3>
                <p class="text-muted mb-0">Total Utilisateurs</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-shield-fill-check text-success fs-1 mb-2"></i>
                <h3 class="h4 mb-1">{{ $admins }}</h3>
                <p class="text-muted mb-0">Administrateurs</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-person-video3 text-info fs-1 mb-2"></i>
                <h3 class="h4 mb-1">{{ $professors }}</h3>
                <p class="text-muted mb-0">Professeurs</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-backpack text-warning fs-1 mb-2"></i>
                <h3 class="h4 mb-1">{{ $students }}</h3>
                <p class="text-muted mb-0">Étudiants</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-person-video3 me-2"></i>Créer un compte Professeur
                </h5>
                <p class="text-muted">Créez un compte pour un nouveau professeur</p>
                <a href="{{ route('admin.create-professor') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter Professeur
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-backpack me-2"></i>Créer un compte Étudiant
                </h5>
                <p class="text-muted">Créez un compte pour un nouvel étudiant</p>
                <a href="{{ route('admin.create-student') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter Étudiant
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-list-ul me-2"></i>Gérer les utilisateurs
                </h5>
                <p class="text-muted">Voir et gérer tous les utilisateurs du système</p>
                <a href="{{ route('admin.users-list') }}" class="btn btn-outline-primary">
                    <i class="bi bi-eye me-2"></i>Voir tous les utilisateurs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
