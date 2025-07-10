<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'DRSS - Courrier')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Logo ou nom de l'app -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
    <img src="{{ asset('logo.png') }}" alt="Logo DRSS" style="height: 40px;">
</a>


        <!-- Bouton responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Liens de gauche -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('courriers.index') }}">Courriers</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('rapports.index') }}">Rapports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('personnels.index') }}">Personnel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('suivis.index') }}">Suivi du personnel</a>
                </li>

            </ul>
            <!-- Partie droite : utilisateur -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1">{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Déconnexion</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                @endauth
                @role('admin')
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.roles.index') }}">Gestion des Rôles</a>
                </li> --}}
                @endrole


<!-- resources/views/layouts/app.blade.php -->
<ul class="navbar-nav ms-auto">
    @auth
        @if(auth()->user()->hasRole('admin'))
            <li class="nav-item">
                <p class="nav-link text-success">Vous êtes admin</p>
            </li>
        @else
            <li class="nav-item">
                <p class="nav-link text-danger">Vous n'êtes pas admin</p>
            </li>
        @endif
        <!-- autres liens -->
    @endauth
</ul>

            </ul>
        </div>
    </div>
</nav>

    <!-- Contenu principal -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Pied de page -->
    <footer class="bg-light text-center py-3 mt-4">
        <small>DRSS © {{ date('M-Y') }}</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
