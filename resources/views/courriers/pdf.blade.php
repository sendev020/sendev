<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des courriers</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .logo {
            height: 60px;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f0f0f0;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ public_path('logo.png') }}" class="logo" alt="Logo">
        <div>
            <strong>Direction Régionale de la Santé de Sédhiou</strong><br>
            Service Courrier
        </div>
    </header>

    <h1>Liste des courriers</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Expéditeur</th>
                <th>Destinataire</th>
                <th>Date réception</th>
                <th>Objet</th>
                <th>Référence</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courriers as $index => $courrier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucfirst($courrier->type) }}</td>
                    <td>{{ $courrier->expediteur }}</td>
                    <td>{{ $courrier->destinataire }}</td>
                    <td>{{ \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') }}</td>
                    <td>{{ $courrier->objet }}</td>
                    <td>{{ $courrier->reference }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
