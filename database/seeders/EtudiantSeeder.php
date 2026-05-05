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
        // Récupérer les filières et modules existants
        $ginfo = Filiere::where('nom', 'LIKE', '%GINFO%')->first();
        $phpModule = \App\Models\Module::where('code', 'PHP101')->first();
        $dbModule = \App\Models\Module::where('code', 'DB202')->first();

        // Créer des étudiants supplémentaires
        $e1 = Etudiant::create([
            'nom' => 'Benjelloun',
            'prenom' => 'Ahmed',
            'email' => 'a.benjelloun@upf.ma',
            'filiere_id' => $ginfo->id,
        ]);

        // Ajouter des notes détaillées
        Note::create([
            'etudiant_id' => $e1->id,
            'module_id' => $phpModule->id,
            'cc1' => 15,
            'cc2' => 16,
            'examen' => 14,
            'note_finale' => 14.8, // (15*0.2 + 16*0.2 + 14*0.6)
            'semestre' => 'S1'
        ]);

        Note::create([
            'etudiant_id' => $e1->id,
            'module_id' => $dbModule->id,
            'cc1' => 12,
            'cc2' => 14,
            'examen' => 15,
            'note_finale' => 14.2,
            'semestre' => 'S1'
        ]);

        // Mettre à jour la moyenne de l'étudiant
        $e1->update(['moyenne' => $e1->notes()->avg('note_finale')]);
    }
}
