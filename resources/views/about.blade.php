@extends('layouts.app')

@section('titre', 'À propos')

@section('contenu')
<div class="container">
    <h1 style="color: var(--primary);">À propos de ce Projet</h1>
    <p>Ce projet est réalisé dans le cadre du TP Laravel à l'UPF.</p>
    <p>Il permet de gérer une liste d'étudiants avec leurs filières et moyennes.</p>
</div>
@endsection
