<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création de 5 utilisateurs aléatoires
        User::factory(5)->create();

        // Création d'un administrateur
        User::factory()->create([
            'name' => 't',
            'email' => 't@t',
            'password' => 'a', 
            'admin' => true, // Assurez-vous que la colonne admin est un booléen
        ]);
    }
}
