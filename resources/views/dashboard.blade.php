@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <h1>Bienvenue sur le tableau de bord</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Courriers reçus</h5>
                    <p class="card-text fs-4">{{ $nbRecu }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Courriers envoyés</h5>
                    <p class="card-text fs-4">{{ $nbEnvoye }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

