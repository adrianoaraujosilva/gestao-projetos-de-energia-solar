<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\Integrador;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class IntegradorControllerTest extends TestCase
{
    use DatabaseTransactions;

    private string $integradorEndpoint = '/api/integradores';
    private Integrador $integrador;

    protected function setUp(): void
    {
        parent::setUp();
        // Executa migrações e semea o banco
        Artisan::call('migrate');
        Artisan::call('db:seed');

        // Recupera 1º integrador
        $this->integrador = Integrador::where('tipo', 'ADMIN')->first();
    }

    public function testIndex(): void
    {
        // Simule uma requisição para o método index
        $response = $this->actingAs($this->integrador)->get($this->integradorEndpoint);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testStore()
    {
        // Crie um integrador de exemplo
        $integrador = Integrador::factory()->make()->toArray();
        $integrador['password'] = 'Mudar@123';
        $integrador['password_confirmation'] = 'Mudar@123';

        // Simule uma requisição POST com dados válidos
        $response = $this->actingAs($this->integrador)->post($this->integradorEndpoint, $integrador);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testLogin()
    {
        // Crie um integrador de exemplo
        $dataForm = [
            'email'     => 'admin@admin.com',
            'password'  => 'Admin@123'
        ];

        // Simule uma requisição POST com dados válidos
        $response = $this->post('api/auth/login', $dataForm);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testUpdate()
    {
        // Crie um integrador de exemplo
        $integrador = Integrador::factory()->create()->toArray();

        // Simule uma requisição PUT com dados válidos
        $response = $this->actingAs($this->integrador)->put($this->integradorEndpoint . '/' . $integrador['id'], $integrador);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testType()
    {
        // Crie um integrador de exemplo
        $integrador = Integrador::factory()->create();

        // Simule uma requisição PATCH com dados válidos
        $response = $this->actingAs($this->integrador)->patch($this->integradorEndpoint . '/' . $integrador['id'] . '/tipo', [
            'tipo' => 'ADMIN'
        ]);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testDeactive()
    {
        // Crie um integrador de exemplo
        $integrador = Integrador::factory()->create();

        // Simule uma requisição PATCH com dados válidos
        $response = $this->actingAs($this->integrador)->patch($this->integradorEndpoint . '/' . $integrador['id'] . '/desativar');

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testActive()
    {
        // Crie um integrador de exemplo
        $integrador = Integrador::factory()->create();

        // Simule uma requisição PATCH com dados válidos
        $response = $this->actingAs($this->integrador)->patch($this->integradorEndpoint . '/' . $integrador['id'] . '/ativar');

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }
}
