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
        $user = auth()->user();

        // Redirect students to their own profile
        if ($user->isStudent()) {
            if ($user->etudiant) {
                return redirect()->route('etudiants.show', $user->etudiant->id);
            }
            return redirect()->route('home')->with('error', 'Profil étudiant non trouvé.');
        }

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
            'email' => 'required|email|unique:users,email|unique:etudiants,email',
            'filiere_id' => 'required|exists:filieres,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validatedData) {
            $user = \App\Models\User::create([
                'name' => $validatedData['prenom'] . ' ' . $validatedData['nom'],
                'email' => $validatedData['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validatedData['password']),
                'role' => 'student',
            ]);

            Etudiant::create([
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                'email' => $validatedData['email'],
                'filiere_id' => $validatedData['filiere_id'],
                'user_id' => $user->id,
                'moyenne' => 0,
            ]);
        });

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant et compte de connexion créés avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $etudiant = Etudiant::with(['filiere', 'notes'])->findOrFail($id);

        // Security check: Students can only see their own profile
        if ($user->isStudent() && $etudiant->user_id !== $user->id) {
            if ($user->etudiant) {
                return redirect()->route('etudiants.show', $user->etudiant->id)
                    ->with('error', 'Accès refusé : vous ne pouvez voir que votre propre profil.');
            }
            return redirect()->route('home')->with('error', 'Accès refusé.');
        }

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

