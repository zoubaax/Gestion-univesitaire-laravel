<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Filiere;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Etudiant::with('filiere')->orderBy('nom');

        if ($request->filled('filiere')) {
            $query->where('filiere_id', $request->filiere);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        $etudiants = $query->get();

        // Statistiques (Collections)
        $total = $etudiants->count();
        $moyenne = $etudiants->avg('moyenne');
        $admis = $etudiants->filter(fn($e) => $e->moyenne >= 10)->count();

        return view('etudiants.index', compact('etudiants', 'total', 'moyenne', 'admis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();
        return view('etudiants.create', compact('filieres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email',
            'filiere_id' => 'required|exists:filieres,id',
            'moyenne' => 'nullable|numeric|min:0|max:20',
        ]);

        Etudiant::create($validatedData);

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $etudiant = Etudiant::with(['filiere', 'notes'])->findOrFail($id);

        return view('etudiants.show', compact('etudiant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $filieres = Filiere::orderBy('nom')->get();
        return view('etudiants.edit', compact('etudiant', 'filieres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email,' . $etudiant->id,
            'filiere_id' => 'required|exists:filieres,id',
            'moyenne' => 'nullable|numeric|min:0|max:20',
        ]);

        $etudiant->update($validatedData);

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès !');
    }
}

