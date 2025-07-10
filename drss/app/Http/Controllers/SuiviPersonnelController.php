<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuiviPersonnel;
use App\Models\Personnel;
use Barryvdh\DomPDF\Facade\Pdf;

class SuiviPersonnelController extends Controller
{
    public function index()
{
    $suivis = SuiviPersonnel::with('personnel')->latest()->paginate(20);
    $personnels = Personnel::with('suivis')->get();

    // Détecter les dépassements pour les alertes
    $alertes = [];

    foreach ($personnels as $personnel) {
        foreach (SuiviPersonnel::limitesParType() as $type => $limite) {
            $total = SuiviPersonnel::totalParTypeEtPersonnel($personnel->id, $type);
            if ($total > $limite) {
                $alertes[] = "{$personnel->nom} a dépassé la limite de $type ({$total}/{$limite})";
            }
        }
    }

    return view('suivis.index', compact('suivis', 'personnels', 'alertes'));
}


    public function create()
    {
        $personnels = Personnel::all();
        return view('suivis.create', compact('personnels'));
    }

    public function store(Request $request)
{
    $request->validate([
        'personnel_id' => 'required|exists:personnels,id',
        'type' => 'required|in:congé,absence,retard,permission,maladie',
        'motif' => 'nullable|string',
        'date_debut' => 'required|date',
        'date_fin' => 'nullable|date|after_or_equal:date_debut',
    ]);

    $personnelId = $request->personnel_id;
    $type = $request->type;

    // Calcul des jours
    $debut = new \Carbon\Carbon($request->date_debut);
    $fin = $request->date_fin ? new \Carbon\Carbon($request->date_fin) : $debut;
    $nbJours = $debut->diffInDays($fin) + 1;

    // Limites par type
    $limites = [
        'congé' => 30,
        'absence' => 10,
        'retard' => 5,
        'permission' => 7,
        'maladie' => 15,
    ];

    // Total existant
    $totalActuel = SuiviPersonnel::where('personnel_id', $personnelId)
        ->where('type', $type)
        ->get()
        ->sum(function ($suivi) {
            $debut = new \Carbon\Carbon($suivi->date_debut);
            $fin = $suivi->date_fin ? new \Carbon\Carbon($suivi->date_fin) : $debut;
            return $debut->diffInDays($fin) + 1;
        });

    if (($totalActuel + $nbJours) > $limites[$type]) {
        return redirect()->back()->withInput()->withErrors([
            'type' => "Limite de {$limites[$type]} jours dépassée pour le type \"$type\". Actuel : $totalActuel jours.",
        ]);
    }

    // Enregistrement
    SuiviPersonnel::create($request->all());

    return redirect()->route('suivis.index')->with('success', 'Suivi ajouté avec succès.');
}


    public function show(SuiviPersonnel $suivi)
    {
        return view('suivis.show', compact('suivi'));
    }

    public function edit(SuiviPersonnel $suivi)
    {
        $personnels = Personnel::all();
        return view('suivis.edit', compact('suivi', 'personnels'));
    }

    public function update(Request $request, SuiviPersonnel $suivi)
    {
        $request->validate([
            'personnel_id' => 'required|exists:personnels,id',
            'type' => 'required|in:congé,absence,retard,permission,maladie',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'motif' => 'nullable|string',
        ]);

        $suivi->update($request->all());

        return redirect()->route('suivis.show', $suivi)->with('success', 'Suivi mis à jour.');
    }

    public function destroy(SuiviPersonnel $suivi)
    {
        $suivi->delete();

        return redirect()->route('suivis.index')->with('success', 'Suivi supprimé.');
    }


public function exportCumulsPDF()
{
    $personnels = Personnel::all();
    $limites = SuiviPersonnel::limitesParType();

    return Pdf::loadView('suivis.cumuls_pdf', compact('personnels', 'limites'))
        ->download('suivi_cumuls.pdf');
}

}
