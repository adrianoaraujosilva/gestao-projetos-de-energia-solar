<?php

namespace Database\Factories;

use App\Models\Integrador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class IntegradorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'      => fake()->name(),
            'email'     => fake()->unique()->safeEmail(),
            'tipo'      => 'INTEGRADOR',
            'password'  => 'Mudar@123',
        ];
    }
}
