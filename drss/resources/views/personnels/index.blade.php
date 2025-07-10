
@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('personnels.export.pdf') }}" class="btn btn-danger">Exporter PDF</a>
    <a href="{{ route('personnels.export.excel') }}" class="btn btn-success">Exporter Excel</a>
</div>
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h1>Liste du personnel</h1>
        <a href="{{ route('personnels.create') }}" class="btn btn-success">+ Ajouter un agent</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Poste</th>
                <th>Service</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($personnels as $p)
            <tr>
                <td>
                    @if($p->photo)
                        <img src="{{ asset('storage/' . $p->photo) }}" alt="photo" width="50">
                    @endif
                </td>
                <td>{{ $p->prenom }} {{ $p->nom }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->telephone }}</td>
                <td>{{ $p->poste }}</td>
                <td>{{ $p->service }}</td>
                <td>
                    <a href="{{ route('personnels.show', $p) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route('personnels.edit', $p) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('personnels.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet agent ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
