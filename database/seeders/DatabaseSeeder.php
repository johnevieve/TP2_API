<?php

namespace Database\Seeders;

use App\Models\Missile;
use App\Models\Partie;
use App\Models\User;
use Database\Factories\MissileFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();
        Partie::factory(2)->create();
        Missile::factory(3)->create();
    }
}
