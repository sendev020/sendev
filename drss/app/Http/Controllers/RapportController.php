<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Rapport;

class RapportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['archiver', 'restaurer', 'destroy']);
    }

    // Liste des rapports avec filtre
    public function index(Request $request)
    {
        $filtre = $request->query('filtre', 'actifs');

        $rapports = Rapport::when($filtre === 'archives', function ($query) {
            $query->where('archived', true);
        }, function ($query) {
            $query->where('archived', false);
        })->latest()->get();

        return view('rapports.index', compact('rapports', 'filtre'));
    }

    // Formulaire de création
    public function create()
    {
        return view('rapports.create');
    }

    // Enregistrement d'un nouveau rapport
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);

        $rapport = new Rapport();
        $rapport->titre = $request->titre;

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('rapports', 'public');

            if (!$path) {
                return back()->withErrors(['fichier' => 'Erreur lors de l’enregistrement du fichier.'])->withInput();
            }

            $rapport->fichier = $path;
        } else {
            return back()->withErrors(['fichier' => 'Aucun fichier détecté.'])->withInput();
        }

        $rapport->archived = false;
        $rapport->save();

        return redirect()->route('rapports.index')->with('success', 'Rapport ajouté avec succès.');
    }

    // Téléchargement d’un fichier
     public function download(Rapport $rapport)
{
    dd($rapport);
    if (!$rapport->fichier || !Storage::disk('public')->exists($rapport->fichier)) {
        abort(404, 'Fichier non trouvé');
    }

    $extension = pathinfo($rapport->fichier, PATHINFO_EXTENSION);
    $nomFichier = $rapport->titre . '.' . $extension;

    $path = Storage::disk('public')->path($rapport->fichier);

    return response()->download($path, $nomFichier);
}


    // Archiver un rapport
    public function archiver(Rapport $rapport)
    {
        $rapport->archived = true;
        $rapport->save();

        return redirect()->route('rapports.index')->with('success', 'Rapport archivé.');
    }

    // Restaurer un rapport archivé
    public function restaurer(Rapport $rapport)
    {
        $rapport->archived = false;
        $rapport->save();

        return redirect()->route('rapports.index')->with('success', 'Rapport restauré.');
    }

    // Supprimer un rapport
    public function destroy(Rapport $rapport)
    {
        if ($rapport->fichier && Storage::disk('public')->exists($rapport->fichier)) {
            Storage::disk('public')->delete($rapport->fichier);
        }

        $rapport->delete();

        return redirect()->route('rapports.index')->with('success', 'Rapport supprimé avec succès.');
    }
}
