@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des rôles</h1>

    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">Créer un rôle</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($roles->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Supprimer ce rôle ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $roles->links() }}
    @else
        <p>Aucun rôle trouvé.</p>
    @endif
</div>
@endsection
