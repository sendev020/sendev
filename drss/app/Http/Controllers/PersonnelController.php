<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResumeSuiviExport;
use App\Exports\PersonnelsExport;

class PersonnelController extends Controller
{
    public function index()
    {
        $personnels = Personnel::latest()->paginate(10);
        return view('personnels.index', compact('personnels'));
    }

    public function create()
    {
        return view('personnels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:20',
            'poste' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'anniversaire' => 'nullable|date|max:20',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nom', 'prenom', 'email', 'telephone', 'poste', 'service','anniversaire','adresse']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Personnel::create($data);

        return redirect()->route('personnels.index')->with('success', 'Personnel ajouté avec succès.');
    }

    public function show(Personnel $personnel)
    {
        return view('personnels.show', compact('personnel'));
    }

    public function edit(Personnel $personnel)
    {
        return view('personnels.edit', compact('personnel'));
    }

    public function update(Request $request, Personnel $personnel)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:20',
            'poste' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'anniversaire' => 'nullable|date|max:20',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nom', 'prenom', 'email', 'telephone', 'poste', 'service','anniversaire','adresse']);

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($personnel->photo && Storage::disk('public')->exists($personnel->photo)) {
                Storage::disk('public')->delete($personnel->photo);
            }

            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $personnel->update($data);

        return redirect()->route('personnels.index')->with('success', 'Personnel mis à jour avec succès.');
    }

    public function destroy(Personnel $personnel)
    {
        if ($personnel->photo && Storage::disk('public')->exists($personnel->photo)) {
            Storage::disk('public')->delete($personnel->photo);
        }

        $personnel->delete();

        return redirect()->route('personnels.index')->with('success', 'Personnel supprimé avec succès.');
    }




public function exportPdf()
{
    $personnels = \App\Models\Personnel::all();
    $pdf = Pdf::loadView('personnels.pdf', compact('personnels'));
    return $pdf->download('liste_personnel.pdf');
}

public function exportExcel()
{
    return Excel::download(new PersonnelsExport, 'liste_personnel.xlsx');
}



}
