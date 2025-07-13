<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Suivi - Cumuls</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('logo.png') }}" class="logo" alt="Logo">
        <div>
            <strong>Direction Régionale de la Santé de Sédhiou</strong><br>
            Service IT
        </div>
    </header>
    <h2>Tableau des cumuls par personne</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                @foreach($limites as $type => $limite)
                    <th>{{ ucfirst($type) }} (max {{ $limite }})</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($personnels as $personnel)
                <tr>
                    <td>{{ $personnel->nom }}</td>
                    @foreach($limites as $type => $limite)
                        @php
                            $total = \App\Models\SuiviPersonnel::totalParTypeEtPersonnel($personnel->id, $type);
                        @endphp
                        <td>{{ $total }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
