@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du courrier</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Type :</strong> {{ $courrier->type }}</p>
            <p><strong>Expéditeur :</strong> {{ $courrier->expediteur }}</p>
            <p><strong>Destinataire :</strong> {{ $courrier->destinataire }}</p>
            <p><strong>Date de réception :</strong> {{ $courrier->date_reception }}</p>
            <p><strong>Objet :</strong> {{ $courrier->objet }}</p>
            <p><strong>Référence :</strong> {{ $courrier->reference ?? '-' }}</p>
            @if ($courrier->fichier)
                <p><strong>Fichier :</strong> <a href="{{ asset('storage/' . $courrier->fichier) }}" target="_blank">Télécharger</a></p>
            @endif

            <a href="{{ route('courriers.edit', $courrier) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('courriers.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
@endsection
