<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Models\Cliente;
use App\Models\Integrador;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;;

class ClienteControllerTest extends TestCase
{
    use DatabaseTransactions;

    private string $clienteEndpoint = '/api/clientes';
    private Integrador $integrador;
    private Cliente $cliente;

    protected function setUp(): void
    {
        parent::setUp();
        // Executa migrações
        Artisan::call('migrate');

        // Recupera 1º integrador
        $this->integrador = Integrador::where('tipo', 'INTEGRADOR')->first();
        // Recupera 1º cliente do integrador
        $this->cliente = $this->integrador->cliente()->first();
    }

    public function testIndex(): void
    {
        // Simule uma requisição para o método index
        $response = $this->actingAs($this->integrador)->get($this->clienteEndpoint);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testStore(): void
    {
        // Crie um cliente de exemplo
        $cliente = Cliente::factory(['integrador_id' => $this->integrador->id])->make()->toArray();

        // Simule uma requisição POST com dados válidos
        $response = $this->actingAs($this->integrador)->post($this->clienteEndpoint, $cliente);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testShow()
    {
        // Simule uma requisição para o método show com o ID do cliente criado
        $response = $this->actingAs($this->integrador)->get("/api/clientes/{$this->cliente->id}");

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testUpdate()
    {
        // Crie um cliente de exemplo
        $cliente = Cliente::factory()->make()->toArray();

        // Simule uma requisição PUT com dados válidos
        $response = $this->actingAs($this->integrador)->put("/api/clientes/{$this->cliente->id}", $cliente);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testValidationErrorsOnStore()
    {
        // Simular uma requisição POST com dados inválidos
        $response = $this->actingAs($this->integrador)->post($this->clienteEndpoint, []);

        // Verificar se a resposta é um JSON e se o status é 422 (Unprocessable Entity)
        $response->assertJsonStructure(['message', 'errors'])->assertStatus(422);
    }

    public function testNotFoundOnShow()
    {
        // Simular uma requisição para o método show com um ID inexistente
        $response = $this->actingAs($this->integrador)->get("/api/clientes/9999");

        // Verificar se a resposta é um JSON e se o status é 404 (Not Found)
        $response->assertJsonStructure(['message'])->assertStatus(404);
    }
}
