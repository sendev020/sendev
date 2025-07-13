@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Rapports @if($filtre === 'archives')(Archivés)@endif</h1>
        <a href="{{ route('rapports.create') }}" class="btn btn-success">+ Ajouter un rapport</a>
    </div>

    <!-- Onglets de filtre -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $filtre === 'actifs' ? 'active' : '' }}" href="{{ route('rapports.index', ['filtre' => 'actifs']) }}">Actifs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filtre === 'archives' ? 'active' : '' }}" href="{{ route('rapports.index', ['filtre' => 'archives']) }}">Archivés</a>
        </li>
    </ul>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($rapports->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Fichier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($rapports as $rapport)
                <tr>
                    <td>{{ $rapport->titre }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $rapport->fichier) }}" target="_blank">Voir</a>
                    </td>
                    <td>
                        @if(!$rapport->archived)
                            <form action="{{ route('rapports.archiver', $rapport) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-warning" onclick="return confirm('Archiver ce rapport ?')">Archiver</button>
                            </form>
                        @else
                            <form action="{{ route('rapports.restaurer', $rapport) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-primary" onclick="return confirm('Restaurer ce rapport ?')">Restaurer</button>
                            </form>
                        @endif
                        <form action="{{ route('rapports.destroy', $rapport) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce rapport ?');" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
</form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun rapport trouvé.</p>
    @endif
</div>
@endsection
