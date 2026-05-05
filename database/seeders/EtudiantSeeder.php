<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Note;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les filières
        $ginfo = Filiere::create(['nom' => 'GINFO']);
        $ddw = Filiere::create(['nom' => 'DDW']);

        // Créer des étudiants
        $e1 = Etudiant::create([
            'nom' => 'Benjelloun',
            'prenom' => 'Ahmed',
            'email' => 'a.benjelloun@upf.ma',
            'filiere_id' => $ginfo->id,
            'moyenne' => 0 // Sera calculée par les notes
        ]);

        $e2 = Etudiant::create([
            'nom' => 'Mansouri',
            'prenom' => 'Laila',
            'email' => 'l.mansouri@upf.ma',
            'filiere_id' => $ddw->id,
            'moyenne' => 0
        ]);

        // Ajouter quelques notes pour tester le calcul de moyenne
        Note::create([
            'etudiant_id' => $e1->id,
            'matiere' => 'PHP Laravel',
            'note' => 17,
            'semestre' => 'S1'
        ]);

        Note::create([
            'etudiant_id' => $e1->id,
            'matiere' => 'Base de données',
            'note' => 15,
            'semestre' => 'S1'
        ]);

        // Mettre à jour la moyenne initiale
        $e1->update(['moyenne' => $e1->notes()->avg('note')]);
    }
}
