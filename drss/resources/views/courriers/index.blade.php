@extends('layouts.app')
@section('content')
<a href="{{ route('courriers.export.excel') }}" class="btn btn-success">Exporter Excel</a>
<a href="{{ route('courriers.export.pdf') }}" class="btn btn-danger">Exporter PDF</a>
<div class="container">
    <h1>Liste des courriers</h1>
    <a href="{{ route('courriers.create') }}" class="btn btn-primary mb-3">Ajouter un courrier</a>
<form method="GET" action="{{ route('courriers.index') }}" class="mb-3 d-flex gap-2">
    <input type="text" name="expediteur" class="form-control" placeholder="Expéditeur" value="{{ request('expediteur') }}">
    <select name="type" class="form-control">
        <option value="">Type</option>
        <option value="recu" {{ request('type') == 'recu' ? 'selected' : '' }}>Reçu</option>
        <option value="envoye" {{ request('type') == 'envoye' ? 'selected' : '' }}>Envoyé</option>
    </select>
    <input type="date" name="date_reception" class="form-control" value="{{ request('date_reception') }}">
    <button class="btn btn-primary">Filtrer</button>
</form>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Expéditeur</th>
                <th>Destinataire</th>
                <th>Date</th>
                <th>Objet</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courriers as $courrier)
            <tr>
                <td>{{ $courrier->type }}</td>
                <td>{{ $courrier->expediteur }}</td>
                <td>{{ $courrier->destinataire }}</td>
                <td>{{ $courrier->date_reception }}</td>
                <td>{{ $courrier->objet }}</td>
                <td>
                    <a href="{{ route('courriers.show', $courrier) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route('courriers.edit', $courrier) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('courriers.destroy', $courrier) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce courrier ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $courriers->links() }}
</div>

@endsection
