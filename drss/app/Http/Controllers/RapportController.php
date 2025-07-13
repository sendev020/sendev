<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Rapport;

class RapportController extends Controller
{
    public function index(Request $request)
{
    $filtre = $request->query('filtre', 'actifs'); // actif ou archives

    $rapports = Rapport::when($filtre === 'archives', function ($query) {
        $query->where('archived', true);
    }, function ($query) {
        $query->where('archived', false);
    })->get();

    return view('rapports.index', compact('rapports', 'filtre'));
}


    public function __construct()
    {
        // Seuls les utilisateurs connectés peuvent accéder à ces méthodes
        $this->middleware('auth');

        // Seuls les administrateurs peuvent archiver ou restaurer
        $this->middleware('role:admin')->only(['archived', 'restore']);
    }

    // Affiche la liste des rapports
    // public function index()
    // {
    //     $rapports = Rapport::where('archived', false)->get();
    //     return view('rapports.index', compact('rapports'));
    // }

    // Formulaire de téléversement
    public function create()
    {
        return view('rapports.create');
    }

    // Enregistre un nouveau rapport
    public function store(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'fichier' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx',
    ]);

    $rapport = new Rapport();
    $rapport->titre = $request->titre;

    if ($request->hasFile('fichier')) {
        // Stocker le fichier dans storage/app/public/rapports
        $path = $request->file('fichier')->store('rapports', 'public');
        // Enregistrer le chemin relatif dans la colonne 'fichier'
        $rapport->fichier = $path;
    }

    $rapport->archived = false;
    $rapport->save();

    return redirect()->route('rapports.index')->with('success', 'Rapport ajouté avec succès.');
}


    // Télécharger un rapport
    public function download(Rapport $rapport)
    {
        return Storage::download($rapport->chemin_fichier, $rapport->titre);
    }

    // Archiver un rapport
    public function archived(Rapport $rapport)
    {
        $rapport->update(['archived' => true]);
        return redirect()->back()->with('success', 'Rapport archivé.');
    }

    // Restaurer un rapport archivé
    public function restore(Rapport $rapport)
    {
        $rapport->update(['archived' => false]);
        return redirect()->back()->with('success', 'Rapport restauré.');
    }

    public function archiver(Rapport $rapport)
{
    $rapport->archived = true;
    $rapport->save();

    return redirect()->route('rapports.index')->with('success', 'Rapport archivé.');
}

public function restaurer(Rapport $rapport)
{
    $rapport->archived = false;
    $rapport->save();

    return redirect()->route('rapports.index')->with('success', 'Rapport restauré.');
}

public function destroy(Rapport $rapport)
{
    // Supprimer le fichier du stockage si il existe
    if ($rapport->fichier && Storage::disk('public')->exists($rapport->fichier)) {
        Storage::disk('public')->delete($rapport->fichier);
    }

    // Supprimer l'entrée en base
    $rapport->delete();

    return redirect()->route('rapports.index')->with('success', 'Rapport supprimé avec succès.');
}
}
