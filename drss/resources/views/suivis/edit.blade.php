@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le suivi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('suivis.update', $suivi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select id="type" name="type" class="form-control" required>
                @foreach(['congé', 'absence', 'retard', 'permission', 'maladie'] as $option)
                    <option value="{{ $option }}" {{ $suivi->type == $option ? 'selected' : '' }}>
                        {{ ucfirst($option) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date début</label>
            <input id="date_debut" type="date" name="date_debut" class="form-control" value="{{ $suivi->date_debut }}" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date fin</label>
            <input id="date_fin" type="date" name="date_fin" class="form-control" value="{{ $suivi->date_fin }}">
        </div>

        <div class="mb-3">
            <label for="motif" class="form-label">Motif</label>
            <textarea id="motif" name="motif" class="form-control" rows="3">{{ $suivi->motif }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('suivis.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
