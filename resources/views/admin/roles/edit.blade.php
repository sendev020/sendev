@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le rôle : {{ $role->name }}</h1>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom du rôle</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $role->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="permissions" class="form-label">Permissions</label>
            <select name="permissions[]" id="permissions" class="form-select" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}"
                        @if($role->hasPermissionTo($permission->name)) selected @endif>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
            @error('permissions')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">Mettre à jour</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn
