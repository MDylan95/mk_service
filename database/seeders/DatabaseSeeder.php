<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Exécuter les seeders de l'application.
     *
     * @return void
     */
    public function run()
    {
        // Appeler les seeders que tu veux exécuter ici
        $this->call([
            AdminSeeder::class,  // Appelle ton seeder personnalisé pour l'administrateur
        ]);
    }
}
