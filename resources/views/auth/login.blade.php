@extends('layouts.app')

@section('titre', 'Connexion')

@section('contenu')
<div class="row justify-content-center py-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Bon retour !</h2>
                    <p class="text-muted">Connectez-vous pour gérer vos étudiants</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Adresse Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required theme="dark">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small text-muted" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary py-3 fw-bold">
                            Se connecter
                        </button>
                    </div>

                    <div class="text-center small text-muted">
                        Pas encore de compte ? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">S'inscrire</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
