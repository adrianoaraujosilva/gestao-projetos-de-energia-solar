<?php

namespace Database\Factories;

use App\Models\Integrador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $integradores = Integrador::pluck('id')->toArray();
        return [
            'nome'          => fake()->name(),
            'email'         => fake()->unique()->safeEmail(),
            'integrador_id' => fake()->randomElement($integradores),
            'telefone'      => fake()->cellphoneNumber(),
            'cpf_cnpj'      => fake()->unique()->cpf(),
        ];
    }
}
