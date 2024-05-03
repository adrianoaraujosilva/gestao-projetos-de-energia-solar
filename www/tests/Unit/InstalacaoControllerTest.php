<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\Instalacao;
use App\Models\Integrador;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InstalacaoControllerTest extends TestCase
{
    use DatabaseTransactions;

    private string $instalacaoEndpoint = '/api/instalacoes';
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
        $response = $this->actingAs($this->integrador)->get($this->instalacaoEndpoint);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testStore(): void
    {
        // Crie uma instalação de exemplo
        $intalacao = Instalacao::factory()->make()->toArray();

        // Simule uma requisição POST com dados válidos
        $response = $this->actingAs($this->integrador)->post($this->instalacaoEndpoint, $intalacao);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testShow()
    {
        // Crie uma instalação de exemplo
        $intalacao = Instalacao::factory()->create();

        // Simule uma requisição para o método show com o ID da instalação criada
        $response = $this->actingAs($this->integrador)->get("$this->instalacaoEndpoint/$intalacao->id}");

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testUpdate()
    {
        // Crie um instalação de exemplo
        $instalacao = Instalacao::factory()->create()->toArray();

        // Simule uma requisição PUT com dados válidos
        $response = $this->actingAs($this->integrador)->put("$this->instalacaoEndpoint/{$instalacao['id']}", $instalacao);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testValidationErrorsOnStore()
    {
        // Simular uma requisição POST com dados inválidos
        $response = $this->actingAs($this->integrador)->post($this->instalacaoEndpoint, []);

        // Verificar se a resposta é um JSON e se o status é 422 (Unprocessable Entity)
        $response->assertJsonStructure(['message', 'errors'])->assertStatus(422);
    }

    public function testNotFoundOnShow()
    {
        // Simular uma requisição para o método show com um ID inexistente
        $response = $this->actingAs($this->integrador)->get("$this->instalacaoEndpoint/9999");

        // Verificar se a resposta é um JSON e se o status é 404 (Not Found)
        $response->assertJsonStructure(['message'])->assertStatus(404);
    }
}
