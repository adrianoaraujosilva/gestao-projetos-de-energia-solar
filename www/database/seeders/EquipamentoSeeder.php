<?php

namespace Database\Seeders;

use App\Models\Equipamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipamentoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipamento::updateOrCreate([
            'nome'     => 'Módulo',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'Inversor',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'Microinversor',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'Estrutura',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'Cabo vermelho',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'Cabo preto',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'String Box',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'Cabo Tronco',
        ], []);
        Equipamento::updateOrCreate([
            'nome'     => 'Endcap',
        ], []);
    }
}
