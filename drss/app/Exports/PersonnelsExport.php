<?php
namespace App\Exports;

use App\Models\Personnel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonnelsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Personnel::select('prenom','nom', 'poste', 'service','telephone', 'email', 'anniversaire', 'adresse' )->get();
    }

    public function headings(): array
    {
        return ['prenom','nom', 'poste', 'service','telephone', 'email', 'anniversaire', 'adresse'];
    }
}

