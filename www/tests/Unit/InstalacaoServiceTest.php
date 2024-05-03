<?php

namespace Tests\Unit;

use App\Filters\InstalacaoFilter;
use App\Http\Resources\InstalacaoResource;
use Tests\TestCase;

use App\Models\Instalacao;
use App\Services\InstalacaoService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class InstalacaoServiceTest extends TestCase
{

    public function testFindAll(): void
    {
        // Criar alguns instalações de exemplo
        Instalacao::factory(5)->create();

        // Cria uma requisição simples para ordenar por ia
        $request = new Request(['ordenar_id' => 'asc']);

        // Criar uma instância de InstalacaoFilter
        $filters = new InstalacaoFilter($request);

        // Chamar o método findAll da InstalacaoService
        $instalacaoService = new InstalacaoService();
        $result = $instalacaoService->findAll($filters);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Lista de Instalações.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result['content']);
    }

    public function testCreate()
    {
        // Força autenticação do usuário 1
        Auth::loginUsingId(1);

        // Gerar dados de instalação de exemplo
        $instalacao = Instalacao::factory()->make()->toArray();

        // Chamar o método create da InstalacaoService
        $instalacaoService = new InstalacaoService();
        $result = $instalacaoService->create($instalacao);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Instalação cadastrada com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(InstalacaoResource::class, $result['content']);
    }

    public function testFind()
    {
        // Criar um instalação de exemplo
        $instalacao = Instalacao::factory()->create();

        // Chamar o método find da InstalacaoService
        $instalacaoService = new InstalacaoService();
        $result = $instalacaoService->find($instalacao);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals("Instalação ID: {$instalacao->id}", $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(InstalacaoResource::class, $result['content']);
    }

    public function testUpdate()
    {
        // Criar um instalação de exemplo
        $instalacao = Instalacao::factory()->create();

        // Gerar dados de atualização de instalação de exemplo
        $requestData = Instalacao::factory()->make()->toArray();

        // Chamar o método update da InstalacaoService
        $instalacaoService = new InstalacaoService();
        $result = $instalacaoService->update($instalacao, $requestData);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Instalação atualizada com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(InstalacaoResource::class, $result['content']);
    }

    public function testCreateValidationErrors()
    {
        // Força autenticação do usuário 1
        Auth::loginUsingId(1);

        // Simular uma chamada ao método create com dados inválidos
        $requestData = [
            'nome' => '', // Nome vazio
        ];

        // Chamar o método create da InstalacaoService
        $instalacaoService = new InstalacaoService();
        $result = $instalacaoService->create($requestData);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Erro ao cadastrar a instalação.', $result['message']);
        $this->assertArrayHasKey('errors', $result);
    }

    public function testUpdateNotFound()
    {
        // Criar um Instalacao de exemplo
        $instalacao = new Instalacao();

        // Chamar o método update da InstalacaoService com um ID inexistente
        $instalacaoService = new InstalacaoService();
        $result = $instalacaoService->update($instalacao, []);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Instalação não encontrada.', $result['message']);
    }
}
