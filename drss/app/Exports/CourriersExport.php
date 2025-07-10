<?php

namespace App\Exports;

use App\Models\Courrier;
use Maatwebsite\Excel\Concerns\FromCollection;

class CourriersExport implements FromCollection
{
    public function collection()
    {
        return Courrier::all();
    }
}

