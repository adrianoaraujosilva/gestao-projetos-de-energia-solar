<?php

namespace Tests\Unit;

use App\Models\Cliente;
use Tests\TestCase;

use App\Models\Integrador;
use App\Models\Projeto;
use Database\Factories\EquipamentoProjetoFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjetoControllerTest extends TestCase
{
    use DatabaseTransactions;

    private string $projetoEndpoint = '/api/projetos';
    private Integrador $integrador;
    private Cliente $cliente;

    protected function setUp(): void
    {
        parent::setUp();

        // Recupera 1º integrador
        $this->integrador = Integrador::where('tipo', 'ADMIN')->first();
        // Recupera 1º cliente do integrador
        $this->cliente = $this->integrador->cliente()->first();
    }

    public function testIndex(): void
    {
        // Simule uma requisição para o método index
        $response = $this->actingAs($this->integrador)->get($this->projetoEndpoint);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testStore(): void
    {
        // Crie uma projetos de exemplo
        $projeto = Projeto::factory(['cliente_id' => $this->cliente->id])->make()->toArray();
        $projeto['equipamentos'] = [EquipamentoProjetoFactory::factoryForModel('EquipamentoProjeto')->make()->toArray()];

        // Simule uma requisição POST com dados válidos
        $response = $this->actingAs($this->integrador)->post($this->projetoEndpoint, $projeto);

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }

    public function testShow()
    {
        // Crie uma projetos de exemplo
        $projeto = Projeto::factory(['cliente_id' => $this->cliente->id])->create();
        // Simule uma requisição para o método show com o ID da projetos criada
        $response = $this->actingAs($this->integrador)->get("$this->projetoEndpoint/$projeto->id}");

        // Verificar se a resposta é um JSON e se o status é 200
        $response->assertJsonStructure(['message', 'content'])->assertStatus(200);
    }
}
