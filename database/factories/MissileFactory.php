<?php

namespace Database\Factories;

use App\Models\Partie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Classe pour la création d'un model d'un missile pour la base de donnée.
 *
 * @extends Factory<User>
 */
class MissileFactory extends Factory
{
    /**
     * Définissez l'état par défaut du modèle.
     *
     * @return array<string, mixed> array du model.
     */
    public function definition(): array
    {
        return [
            'partie_id' => Partie::first(),
            'coordonnee' => chr(ord('A') + rand(1, 10) - 1) . '-' . rand(1, 10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
