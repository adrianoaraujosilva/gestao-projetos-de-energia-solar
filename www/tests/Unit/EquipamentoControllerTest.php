<?php

namespace Tests\Unit;

use App\Models\Equipamento;
use Tests\TestCase;

use App\Models\Integrador;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EquipamentoControllerTest extends TestCase
{
    use DatabaseTransactions;

    private string $equipamentoEndpoint = '/api/equipamentos';
    private Integrador $integrador;

    protected function setUp(): void
    {
        parent::setUp();

        // Recupera 1º integrador
        $this->integrador = Integrador::where('tipo', 'ADMIN')->first();
    }

    public function testIndex(): void
    {
        // Simule uma requisição para o método index
        $response = $this->actingAs($this->integrador)->get($this->equipamentoEndpoint);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testStore(): void
    {
        // Crie uma equipamentos de exemplo
        $equipamento = Equipamento::factory()->make()->toArray();

        // Simule uma requisição POST com dados válidos
        $response = $this->actingAs($this->integrador)->post($this->equipamentoEndpoint, $equipamento);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testShow()
    {
        // Crie uma equipamentos de exemplo
        $equipamento = Equipamento::factory()->create();

        // Simule uma requisição para o método show com o ID da equipamentos criada
        $response = $this->actingAs($this->integrador)->get("$this->equipamentoEndpoint/$equipamento->id}");

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testUpdate()
    {
        // Crie um equipamentos de exemplo
        $equipamento = Equipamento::factory()->create()->toArray();

        // Simule uma requisição PUT com dados válidos
        $response = $this->actingAs($this->integrador)->put("$this->equipamentoEndpoint/{$equipamento['id']}", $equipamento);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testValidationErrorsOnStore()
    {
        // Simular uma requisição POST com dados inválidos
        $response = $this->actingAs($this->integrador)->post($this->equipamentoEndpoint, []);

        // Verificar se a resposta é um JSON e se o status é 422 (Unprocessable Entity)
        $response->assertJsonStructure(['message', 'errors'])->assertStatus(422);
    }

    public function testNotFoundOnShow()
    {
        // Simular uma requisição para o método show com um ID inexistente
        $response = $this->actingAs($this->integrador)->get("$this->equipamentoEndpoint/9999");

        // Verificar se a resposta é um JSON e se o status é 404 (Not Found)
        $response->assertJsonStructure(['message'])->assertStatus(404);
    }
}
