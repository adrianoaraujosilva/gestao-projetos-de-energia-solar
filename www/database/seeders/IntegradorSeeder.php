<?php

namespace Database\Seeders;

use App\Models\Integrador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntegradorSeeder extends Seeder
{
    private const SENHA = 'Admin@123';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Integrador::updateOrCreate([
            'email'     => 'admin@admin.com',
        ], [
            'nome'      => 'Admin',
            'tipo'      => 'ADMIN',
            'password'  => $this::SENHA,
        ]);

        Integrador::updateOrCreate([
            'email'     => 'integrador-01@admin.com',
        ], [
            'nome'      => 'Integrador-01',
            'tipo'      => 'INTEGRADOR',
            'password'  => $this::SENHA,
        ]);

        Integrador::updateOrCreate([
            'email'     => 'integrador-02@admin.com',
        ], [
            'nome'      => 'Integrador-02',
            'tipo'      => 'INTEGRADOR',
            'password'  => $this::SENHA,
        ]);
    }
}
