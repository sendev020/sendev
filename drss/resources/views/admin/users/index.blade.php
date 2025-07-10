@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l’utilisateur : {{ $user->name }}</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="roles" class="form-label">Rôles</label>
            <select name="roles[]" id="roles" class="form-select" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
