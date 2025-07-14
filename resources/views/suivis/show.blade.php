@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détail du suivi</h2>

    <p><strong>Nom :</strong> {{ $suivi->personnel->nom }}</p>
    <p><strong>Type :</strong> {{ ucfirst($suivi->type) }}</p>
    <p><strong>Date début :</strong> {{ $suivi->date_debut }}</p>
    <p><strong>Date fin :</strong> {{ $suivi->date_fin ?? '-' }}</p>
    <p><strong>Motif :</strong> {{ $suivi->motif }}</p>
    <div class="d-flex gap-2 mt-4">
        <a href="{{ route('suivis.index') }}" class="btn btn-secondary">← Retour</a>
        <a href="{{ route('suivis.edit', $suivi->id) }}" class="btn btn-primary">Modifier</a>

        <form action="{{ route('suivis.destroy', $suivi->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce suivi ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>
@endsection
