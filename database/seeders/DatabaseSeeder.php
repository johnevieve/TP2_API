<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Classe pour l'amorçage de la base de donnée.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Amorcez la base de données de l'application.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create();
    }
}
