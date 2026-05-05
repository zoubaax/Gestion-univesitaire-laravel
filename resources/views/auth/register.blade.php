@extends('layouts.app')

@section('titre', 'Créer un compte')

@section('contenu')
<div class="row justify-content-center py-5">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Rejoignez-nous</h2>
                    <p class="text-muted">Commencez à gérer votre établissement aujourd'hui</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nom complet</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Adresse Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirmer</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary py-3 fw-bold">
                            Créer mon compte
                        </button>
                    </div>

                    <div class="text-center small text-muted">
                        Déjà un compte ? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Se connecter</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
