<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Création d'un administrateur avec mot de passe hashé
        Utilisateur::create([
            'name' => 'MK Service',
            'email' => 'mkservice@gmail.com',
            'password' => Hash::make('mk2025'),
        ]);
    }
}
