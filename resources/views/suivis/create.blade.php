@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un suivi</h1>
    <form action="{{ route('suivis.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="personnel_id" class="form-label">Personnel</label>
            <select name="personnel_id" class="form-control" required>
                @foreach($personnels as $personnel)
                    <option value="{{ $personnel->id }}">{{ $personnel->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" class="form-control" required>
                <option value="congé">Congé</option>
                <option value="absence">Absence</option>
                <option value="retard">Retard</option>
                <option value="permission">Permission</option>
                <option value="maladie">Maladie</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date début</label>
            <input type="date" name="date_debut" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date fin (facultatif)</label>
            <input type="date" name="date_fin" class="form-control">
        </div>

        <div class="mb-3">
            <label for="motif" class="form-label">Motif</label>
            <textarea name="motif" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('suivis.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
