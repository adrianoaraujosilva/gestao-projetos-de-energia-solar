<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Instalacao;
use App\Models\Projeto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ProjetoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientes = Cliente::pluck('id')->toArray();
        $instalacoes = Instalacao::pluck('id')->toArray();

        return [
            'nome'          => fake()->word(),
            'cliente_id'    => fake()->randomElement($clientes),
            'uf'            => fake()->randomElement(Projeto::UF),
            'instalacao_id' => fake()->randomElement($instalacoes),
        ];
    }
}
