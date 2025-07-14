@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Modifier le courrier</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courriers.update', $courrier->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Type de courrier</label>
            <select name="type" id="type" class="form-select" required>
                <option value="recu" {{ $courrier->type == 'recu' ? 'selected' : '' }}>Reçu</option>
                <option value="envoye" {{ $courrier->type == 'envoye' ? 'selected' : '' }}>Envoyé</option>
            </select>
        </div>

        <!-- Expéditeur -->
        <div class="mb-3">
            <label for="expediteur" class="form-label">Expéditeur</label>
            <input type="text" class="form-control" id="expediteur" name="expediteur"
                   value="{{ old('expediteur', $courrier->expediteur) }}" required>
        </div>

        <!-- Destinataire -->
        <div class="mb-3">
            <label for="destinataire" class="form-label">Destinataire</label>
            <input type="text" class="form-control" id="destinataire" name="destinataire"
                   value="{{ old('destinataire', $courrier->destinataire) }}" required>
        </div>

        <!-- Date de réception -->
        <div class="mb-3">
            <label for="date_reception" class="form-label">Date de réception</label>
            <input type="date" class="form-control" id="date_reception" name="date_reception"
                   value="{{ old('date_reception', \Carbon\Carbon::parse($courrier->date_reception)->format('Y-m-d')) }}"
>
        </div>

        <!-- Objet -->
        <div class="mb-3">
            <label for="objet" class="form-label">Objet</label>
            <input type="text" class="form-control" id="objet" name="objet"
                   value="{{ old('objet', $courrier->objet) }}" required>
        </div>

        <!-- Référence -->
        <div class="mb-3">
            <label for="reference" class="form-label">Référence</label>
            <input type="text" class="form-control" id="reference" name="reference"
                   value="{{ old('reference', $courrier->reference) }}">
        </div>

        <!-- Fichier -->
        <div class="mb-3">
            <label for="fichier" class="form-label">Pièce jointe (si vous souhaitez la remplacer)</label>
            <input type="file" class="form-control" name="fichier" id="fichier">
            @if ($courrier->fichier)
                <p class="mt-2">Fichier actuel :
                    <a href="{{ asset('storage/' . $courrier->fichier) }}" target="_blank">Voir la pièce jointe</a>
                </p>
            @endif
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('courriers.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
