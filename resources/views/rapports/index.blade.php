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
                            @if($rapport->fichier)
                                {{-- <a href="{{ asset('storage/' . $rapport->fichier) }}" target="_blank">Voir</a> --}}
                                <a href="{{ route('rapports.view', $rapport) }}" target="_blank">Voir</a>

                            @else
                                <em>Pas de fichier</em>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('rapports.download', $rapport) }}" class="btn btn-sm btn-primary me-1">
                                Télécharger
                            </a>

                            @if(!$rapport->archived)
                                <form action="{{ route('rapports.archiver', $rapport) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-warning">Archiver</button>
                                </form>
                            @else
                                <form action="{{ route('rapports.restaurer', $rapport) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-secondary">Restaurer</button>
                                </form>
                            @endif

                            <form action="{{ route('rapports.destroy', $rapport) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Supprimer ce rapport ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Supprimer</button>
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
