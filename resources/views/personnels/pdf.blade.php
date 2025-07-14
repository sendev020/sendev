<!DOCTYPE html>
<html>
<head>
    <title>Liste du Personnel</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .logo {
            width: 150px;
            height: auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h2>Liste du Personnel</h2>
        </div>
        <div>
           <img src="{{ public_path('logo.png') }}" class="logo" alt="Logo">
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Poste</th>
                <th>Service</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date de naissance</th>
                <th>Adresse</th>
                <!-- Ne pas inclure la photo -->
            </tr>
        </thead>
        <tbody>
            @foreach($personnels as $personnel)
                <tr>
                    <td>{{ $personnel->prenom }}{{ $personnel->nom }}</td>
                    <td>{{ $personnel->poste }}</td>
                    <td>{{ $personnel->service }}</td>
                    <td>{{ $personnel->email }}</td>
                    <td>{{ $personnel->telephone }}</td>
                    <td>{{ $personnel->anniversaire }}</td>
                    <td>{{ $personnel->adresse }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
