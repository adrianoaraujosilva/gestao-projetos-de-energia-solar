<?php

namespace Database\Seeders;

use App\Models\Integrador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntegradorSeeder extends Seeder
{
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
            'password'  => 'Admin@123',
        ]);

        Integrador::factory()->count(10)->create();
    }
}
