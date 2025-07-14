@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un nouveau rôle</h1>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom du rôle</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="permissions" class="form-label">Permissions</label>
            <select name="permissions[]" id="permissions" class="form-select" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
            @error('permissions')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success" type="submit">Créer</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
