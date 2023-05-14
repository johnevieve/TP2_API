<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Classe pour la création d'un model d'une partie pour la base de donnée.
 *
 * @extends Factory<User>
 */
class PartieFactory extends Factory
{
    /**
     * Définissez l'état par défaut du modèle.
     *
     * @return array<string, mixed> array du model.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::first(),
            'adversaire' => fake()->name(),
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
