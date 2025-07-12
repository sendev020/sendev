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
        $this->middleware('role:admin')->only(['archived', 'restore']);
    }

    public function index(Request $request)
    {
        $filtre = $request->query('filtre', 'actifs');

        $rapports = Rapport::when($filtre === 'archives', function ($query) {
            $query->where('archived', true);
        }, function ($query) {
            $query->where('archived', false);
        })->get();

        return view('rapports.index', compact('rapports', 'filtre'));
    }

    public function create()
    {
        return view('rapports.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'fichier' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240', // max 10Mo
    ]);

    $rapport = new Rapport();
    $rapport->titre = $request->titre;

    if ($request->hasFile('fichier')) {
        // Stocker le fichier dans storage/app/public/rapports
        $path = $request->file('fichier')->store('rapports', 'public');

        if (!$path) {
            return back()->withErrors(['fichier' => 'Erreur lors du téléchargement du fichier.'])->withInput();
        }

        // Enregistrer le chemin relatif dans la colonne 'fichier'
        $rapport->fichier = $path;
    } else {
        // En théorie, la validation empêche d'arriver ici, mais on double la sécurité
        return back()->withErrors(['fichier' => 'Veuillez sélectionner un fichier à télécharger.'])->withInput();
    }

    $rapport->archived = false;
    $rapport->save();

    return redirect()->route('rapports.index')->with('success', 'Rapport ajouté avec succès.');
}

    public function download(Rapport $rapport)
{
    if (!$rapport->fichier || !Storage::disk('public')->exists($rapport->fichier)) {
        abort(404, 'Fichier non trouvé');
    }

    $extension = pathinfo($rapport->fichier, PATHINFO_EXTENSION);
    $nomFichier = $rapport->titre . '.' . $extension;

    $path = Storage::disk('public')->path($rapport->fichier);

    return response()->download($path, $nomFichier);
}


    public function archived(Rapport $rapport)
    {
        $rapport->update(['archived' => true]);
        return redirect()->back()->with('success', 'Rapport archivé.');
    }

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
        if ($rapport->fichier && Storage::disk('public')->exists($rapport->fichier)) {
            Storage::disk('public')->delete($rapport->fichier);
        }

        $rapport->delete();

        return redirect()->route('rapports.index')->with('success', 'Rapport supprimé avec succès.');
    }
}
