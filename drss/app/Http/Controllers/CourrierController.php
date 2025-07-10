<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use Illuminate\Http\Request;
use App\Exports\CourriersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CourrierController extends Controller
{
    public function index(Request $request)
{
    $query = Courrier::query();

    if ($request->filled('expediteur')) {
        $query->where('expediteur', 'like', '%' . $request->expediteur . '%');
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('date_reception')) {
        $query->whereDate('date_reception', $request->date_reception);
    }

    $courriers = $query->latest()->paginate(10);

    return view('courriers.index', compact('courriers'));
}


    public function create()
    {
        return view('courriers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:recu,envoye',
            'expediteur' => 'required|string',
            'destinataire' => 'required|string',
            'date_reception' => 'required|date',
            'objet' => 'required|string',
            'reference' => 'nullable|string',
        ]);

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('courriers', 'public');
            $validated['fichier'] = $path;
        }

        Courrier::create($validated);

        return redirect()->route('courriers.index')->with('success', 'Courrier ajouté avec succès.');
    }

    public function show(Courrier $courrier)
    {
        return view('courriers.show', compact('courrier')
        )
        ;
    }

    public function edit(Courrier $courrier)
    {
        return view('courriers.edit', compact('courrier'));
    }

    public function update(Request $request, Courrier $courrier)
    {
        $validated = $request->validate([
            'type' => 'required|in:recu,envoye',
            'expediteur' => 'required|string',
            'destinataire' => 'required|string',
            'date_reception' => 'required|date',
            'objet' => 'required|string',
        ]);

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('courriers', 'public');
            $validated['fichier'] = $path;
        }

        $courrier->update($validated);

        return redirect()->route('courriers.index')->with('success', 'Courrier modifié avec succès.');
    }
public function exportExcel()
{
    return Excel::download(new CourriersExport, 'courriers.xlsx');
}
public function exportPDF()
{
    $courriers = Courrier::all();
    $pdf = Pdf::loadView('courriers.pdf', compact('courriers'));
    return $pdf->download('courriers.pdf');
}

}

