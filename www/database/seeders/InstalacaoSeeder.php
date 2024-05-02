<?php

namespace Database\Seeders;

use App\Models\Instalacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstalacaoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Instalacao::updateOrCreate([
            'nome'     => 'Fibrocimento (Madeira)',
        ], []);
        Instalacao::updateOrCreate([
            'nome'     => 'Fibrocimento (Metálico)',
        ], []);
        Instalacao::updateOrCreate([
            'nome'     => 'Cerâmico',
        ], []);
        Instalacao::updateOrCreate([
            'nome'     => 'Metálico',
        ], []);
        Instalacao::updateOrCreate([
            'nome'     => 'Laje',
        ], []);
        Instalacao::updateOrCreate([
            'nome'     => 'Solo',
        ], []);
    }
}
