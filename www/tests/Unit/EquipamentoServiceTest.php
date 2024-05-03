<?php

namespace Tests\Unit;

use App\Filters\EquipamentoFilter;
use App\Http\Resources\EquipamentoResource;
use App\Models\Equipamento;
use Tests\TestCase;

use App\Services\EquipamentoService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EquipamentoServiceTest extends TestCase
{

    public function testFindAll(): void
    {
        // Criar alguns equipamentos de exemplo
        Equipamento::factory(5)->create();

        // Cria uma requisição simples para ordenar por ia
        $request = new Request(['ordenar_id' => 'asc']);

        // Criar uma instância de EquipamentoFilter
        $filters = new EquipamentoFilter($request);

        // Chamar o método findAll da EquipamentoService
        $equipamentoService = new EquipamentoService();
        $result = $equipamentoService->findAll($filters);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Lista de Equipamentos.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result['content']);
    }

    public function testCreate()
    {
        // Força autenticação do usuário 1
        Auth::loginUsingId(1);

        // Gerar dados de equipamento de exemplo
        $equipamento = Equipamento::factory()->make()->toArray();

        // Chamar o método create da EquipamentoService
        $equipamentoService = new EquipamentoService();
        $result = $equipamentoService->create($equipamento);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Equipamento cadastrado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(EquipamentoResource::class, $result['content']);
    }

    public function testFind()
    {
        // Criar um equipamento de exemplo
        $equipamento = Equipamento::factory()->create();

        // Chamar o método find da EquipamentoService
        $equipamentoService = new EquipamentoService();
        $result = $equipamentoService->find($equipamento);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals("Equipamento ID: {$equipamento->id}", $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(EquipamentoResource::class, $result['content']);
    }

    public function testUpdate()
    {
        // Criar um equipamento de exemplo
        $equipamento = Equipamento::factory()->create();

        // Gerar dados de atualização de equipamento de exemplo
        $requestData = Equipamento::factory()->make()->toArray();

        // Chamar o método update da EquipamentoService
        $equipamentoService = new EquipamentoService();
        $result = $equipamentoService->update($equipamento, $requestData);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('equipamento atualizada com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(EquipamentoResource::class, $result['content']);
    }

    public function testCreateValidationErrors()
    {
        // Força autenticação do usuário 1
        Auth::loginUsingId(1);

        // Simular uma chamada ao método create com dados inválidos
        $requestData = [
            'nome' => '', // Nome vazio
        ];

        // Chamar o método create da EquipamentoService
        $equipamentoService = new EquipamentoService();
        $result = $equipamentoService->create($requestData);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Erro ao cadastrar a equipamento.', $result['message']);
        $this->assertArrayHasKey('errors', $result);
    }

    public function testUpdateNotFound()
    {
        // Criar um equipamento de exemplo
        $equipamento = new Equipamento();

        // Chamar o método update da EquipamentoService com um ID inexistente
        $equipamentoService = new EquipamentoService();
        $result = $equipamentoService->update($equipamento, []);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('equipamento não encontrada.', $result['message']);
    }
}
