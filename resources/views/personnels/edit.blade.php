
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'agent</h1>

    <form action="{{ route('personnels.update', $personnel) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


<div class="mb-3">
    <label>Nom</label>
    <input type="text" name="nom" class="form-control" value="{{ old('nom', $personnel->nom ?? '') }}">
</div>
<div class="mb-3">
    <label>Prénom</label>
    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $personnel->prenom ?? '') }}">
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $personnel->email ?? '') }}">
</div>
<div class="mb-3">
    <label>Téléphone</label>
    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $personnel->telephone ?? '') }}">
</div>
<div class="mb-3">
    <label>Poste</label>
    <input type="text" name="poste" class="form-control" value="{{ old('poste', $personnel->poste ?? '') }}">
</div>
<div class="mb-3">
    <label>Service</label>
    <input type="text" name="service" class="form-control" value="{{ old('service', $personnel->service ?? '') }}">
</div>
<div class="mb-3">
    <label>Anniversaire</label>
    <input type="date" name="anniversaire" class="form-control" value="{{ old('anniversaire', $personnel->anniversaire ?? '') }}">
</div>
<div class="mb-3">
    <label>Adresse</label>
    <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $personnel->adresse ?? '') }}">
</div>
<div class="mb-3">
    <label>Photo</label>
    <input type="file" name="photo" class="form-control">
</div>


        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('personnels.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
