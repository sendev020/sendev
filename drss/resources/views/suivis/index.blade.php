@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Suivi du personnel</h1>
        <a href="{{ route('suivis.create') }}" class="btn btn-success">+ Ajouter un suivi</a>
    </div>
    @if(session('success'))
    @if(!empty($alertes))
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($alertes as $alerte)
                <li>{{ $alerte }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Motif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suivis as $suivi)
                <tr>
                    <td>{{ $suivi->personnel->nom }}</td>
                    <td>{{ ucfirst($suivi->type) }}</td>
                    <td>{{ $suivi->date_debut }}</td>
                    <td>{{ $suivi->date_fin ?? '-' }}</td>
                    <td>{{ $suivi->motif }}</td>
                    <td>
                        <a href="{{ route('suivis.show', $suivi) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('suivis.edit', $suivi) }}" class="btn btn-primary btn-sm">Modifier</a>
                        <form action="{{ route('suivis.destroy', $suivi) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce suivi ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <a href="{{ route('suivis.export.cumuls') }}" class="btn btn-outline-dark float-end mb-3">
    📄 Exporter les cumuls PDF
</a>
    </div>
<h2 class="mt-5">Cumul par personne</h2>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            @foreach(\App\Models\SuiviPersonnel::limitesParType() as $type => $limite)
                <th>{{ ucfirst($type) }} (limite: {{ $limite }})</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($personnels as $personnel)
            <tr>
                <td>{{ $personnel->nom }}</td>
                @foreach(\App\Models\SuiviPersonnel::limitesParType() as $type => $limite)
                    @php
                        $total = \App\Models\SuiviPersonnel::totalParTypeEtPersonnel($personnel->id, $type);
                        $alert = $total > $limite ? 'text-danger fw-bold' : '';
                    @endphp
                    <td class="{{ $alert }}">
                        {{ $total }} / {{ $limite }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

    {{ $suivis->links() }}
</div>
@endsection
