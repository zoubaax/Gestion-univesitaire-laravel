<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Créer les Filières
        $f1 = \App\Models\Filiere::create(['nom' => 'Génie Informatique (GINFO)']);
        $f2 = \App\Models\Filiere::create(['nom' => 'Digital Design & Web (DDW)']);

        // 2. Créer les Modules
        $m1 = \App\Models\Module::create(['nom' => 'Programmation PHP', 'code' => 'PHP101', 'filiere_id' => $f1->id]);
        $m2 = \App\Models\Module::create(['nom' => 'Base de Données', 'code' => 'DB202', 'filiere_id' => $f1->id]);
        $m3 = \App\Models\Module::create(['nom' => 'UI/UX Design', 'code' => 'UIX303', 'filiere_id' => $f2->id]);

        // 3. Créer l'administrateur
        \App\Models\User::create([
            'name' => 'Administrateur',
            'email' => 'admin@upf.ma',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 4. Créer un professeur
        \App\Models\User::create([
            'name' => 'Professeur Ahmed',
            'email' => 'professeur@upf.ma',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'professor',
        ]);

        // 5. Créer un étudiant et son profil
        $userStudent = \App\Models\User::create([
            'name' => 'Étudiant Test',
            'email' => 'etudiant@upf.ma',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'student',
        ]);

        \App\Models\Etudiant::create([
            'nom' => 'Test',
            'prenom' => 'Étudiant',
            'email' => 'etudiant@upf.ma',
            'filiere_id' => $f1->id,
            'user_id' => $userStudent->id,
        ]);

        $this->call([
            EtudiantSeeder::class,
        ]);
    }
}
