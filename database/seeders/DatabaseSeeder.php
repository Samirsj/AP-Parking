<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifie et crée un utilisateur admin unique
        if (!User::where('email', 't@t')->exists()) {
            User::create([
                'name' => 'teste',
                'email' => 't@t',
                'password' => Hash::make('a'), 
                'admin' => 1,
            ]);
        }

        User::factory(10)->create();
    }
}
