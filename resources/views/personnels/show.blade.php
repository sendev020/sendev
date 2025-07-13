
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du personnel : {{ $personnel->nom }} {{ $personnel->prenom }}</h1>
    <a href="{{ route('personnels.index') }}" class="btn btn-secondary mb-3">← Retour</a>
    <div class="card">
        <div class="card-body">
            @if($personnel->photo)
                <img src="{{ asset('storage/' . $personnel->photo) }}" width="120" class="mb-3">
            @endif
            <p><strong>Nom :</strong> {{ $personnel->prenom }} {{ $personnel->nom }}</p>
            <p><strong>Email :</strong> {{ $personnel->email }}</p>
            <p><strong>Téléphone :</strong> {{ $personnel->telephone }}</p>
            <p><strong>Poste :</strong> {{ $personnel->poste }}</p>
            <p><strong>Service :</strong> {{ $personnel->service }}</p>
            <p><strong>Anniversaire :</strong> {{ $personnel->anniversaire }}</p>
            <p><strong>Adresse :</strong> {{ $personnel->adresse }}</p>
        </div>
    </div>
</div>
@endsection
