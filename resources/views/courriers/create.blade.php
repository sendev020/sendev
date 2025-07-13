@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un courrier</h1>

    <form enctype="multipart/form-data" action="{{ route('courriers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="recu">Reçu</option>
                <option value="envoye">Envoyé</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Expéditeur</label>
            <input type="text" name="expediteur" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Destinataire</label>
            <input type="text" name="destinataire" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date de réception</label>
            <input type="date" name="date_reception" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Objet</label>
            <textarea name="objet" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Référence (optionnelle)</label>
            <input type="text" name="reference" class="form-control">
        </div>

        <div class="mb-3">
    <label>Fichier (PDF, image…)</label>
    <input type="file" name="fichier" class="form-control">
</div>


        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('courriers.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
