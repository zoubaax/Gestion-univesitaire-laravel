<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Show the form for creating a new note.
     */
    public function create(Etudiant $etudiant)
    {
        return view('notes.create', compact('etudiant'));
    }

    /**
     * Store a newly created note in storage.
     */
    public function store(Request $request, Etudiant $etudiant)
    {
        $validatedData = $request->validate([
            'matiere' => 'required|string|max:255',
            'note' => 'required|numeric|min:0|max:20',
            'semestre' => 'required|in:S1,S2',
        ]);

        $note = new Note($validatedData);
        $note->etudiant_id = $etudiant->id;
        $note->save();

        // Facultatif: Mettre à jour la moyenne globale de l'étudiant dans sa table
        $nouvelleMoyenne = $etudiant->notes()->avg('note');
        $etudiant->update(['moyenne' => $nouvelleMoyenne]);

        return redirect()->route('etudiants.show', $etudiant->id)
            ->with('success', 'Note ajoutée avec succès !');
    }
}
