<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::updateOrCreate([
            'email'     => 'joao@admin.com',
        ], [
            'integrador_id' => 2,
            'nome'          => 'João',
            'telefone'      => '(11) 99999-9990',
            'cpf_cnpj'      => '10266799078',
        ]);

        Cliente::updateOrCreate([
            'email'     => 'jose@admin.com',
        ], [
            'integrador_id' => 3,
            'nome'          => 'José',
            'telefone'      => '(11) 99999-9991',
            'cpf_cnpj'      => '56807357000130',
        ]);

        Cliente::updateOrCreate([
            'email'     => 'maria@admin.com',
        ], [
            'integrador_id' => 2,
            'nome'          => 'Maria',
            'telefone'      => '(11) 99999-9992',
            'cpf_cnpj'      => '21397044000177',
        ]);

        Cliente::updateOrCreate([
            'email'     => 'marta@admin.com',
        ], [
            'integrador_id' => 3,
            'nome'          => 'Marta',
            'telefone'      => '(11) 99999-9993',
            'cpf_cnpj'      => '32437746080',
        ]);
    }
}
