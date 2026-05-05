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
        // Créer un utilisateur test
        \App\Models\User::create([
            'name' => 'Professeur Ahmed',
            'email' => 'admin@upf.ma',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        $this->call([
            EtudiantSeeder::class,
        ]);
    }
}
