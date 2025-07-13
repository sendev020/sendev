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
            'fichier' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);

        $rapport = new Rapport();
        $rapport->titre = $request->titre;

        if ($request->hasFile('fichier')) {
            $rapport->fichier = $request->file('fichier')->store('rapports', 'public');
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

        $nomFichier = basename($rapport->fichier);
        $chemin = Storage::disk('public')->path($rapport->fichier);

        return response()->download($chemin, $nomFichier);
    }

    public function archiver(Rapport $rapport)
    {
        $rapport->update(['archived' => true]);
        return back()->with('success', 'Rapport archivé.');
    }

    public function restaurer(Rapport $rapport)
    {
        $rapport->update(['archived' => false]);
        return back()->with('success', 'Rapport restauré.');
    }

    public function destroy(Rapport $rapport)
    {
        if ($rapport->fichier && Storage::disk('public')->exists($rapport->fichier)) {
            Storage::disk('public')->delete($rapport->fichier);
        }

        $rapport->delete();

        return back()->with('success', 'Rapport supprimé.');
    }
}
