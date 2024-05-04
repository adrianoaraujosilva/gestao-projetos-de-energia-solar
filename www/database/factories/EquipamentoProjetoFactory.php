<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Equipamento;
use App\Models\Projeto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipamentoProjeto>
 */
class EquipamentoProjetoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projetos = Projeto::pluck('id')->toArray();
        $equipamentos = Equipamento::pluck('id')->toArray();

        return [
            'projeto_id'        => fake()->randomElement($projetos),
            'equipamento_id'    => fake()->randomElement($equipamentos),
            'quantidade'        => fake()->randomDigit(),
            'descricao'         => fake()->sentence(),
        ];
    }
}
