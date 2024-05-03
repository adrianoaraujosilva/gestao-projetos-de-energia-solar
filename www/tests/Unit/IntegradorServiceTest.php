<?php

namespace Tests\Unit;

use App\Filters\IntegradorFilter;
use App\Http\Resources\IntegradorResource;
use Tests\TestCase;

use App\Models\Integrador;
use App\Services\IntegradorService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class IntegradorServiceTest extends TestCase
{

    public function testFindAll(): void
    {
        // Criar alguns integradores de exemplo
        Integrador::factory(5)->create();

        // Cria uma requisição simples para ordenar por ia
        $request = new Request(['ordenar_id' => 'asc']);

        // Criar uma instância de IntegradorFilter
        $filters = new IntegradorFilter($request);

        // Chamar o método findAll da IntegradorService
        $integradorService = new IntegradorService();
        $result = $integradorService->findAll($filters);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Lista de integradores.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result['content']);
    }

    public function testCreate()
    {
        // Força autenticação do usuário 1
        Auth::loginUsingId(1);

        // Gerar dados de Integrador de exemplo
        $integrador = Integrador::factory()->make()->toArray();
        $integrador['password'] = 'Mudar@123';
        $integrador['password_confirmation'] = 'Mudar@123';

        // Chamar o método create da IntegradorService
        $integradorService = new IntegradorService();
        $result = $integradorService->create($integrador);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Integrador cadastrado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(IntegradorResource::class, $result['content']);
    }

    public function testLogin()
    {
        // Crie um integrador de exemplo
        $dataForm = [
            'email'     => 'admin@admin.com',
            'password'  => 'Admin@123'
        ];

        // Chamar o método login da IntegradorService
        $integradorService = new IntegradorService();
        $result = $integradorService->login($dataForm);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Login efetuado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
    }

    public function testUpdate()
    {
        // Criar um integrador de exemplo
        $integrador = Integrador::factory()->create();

        // Gerar dados de atualização de integrador de exemplo
        $requestData = Integrador::factory()->make()->toArray();

        // Chamar o método update da IntegradorService
        $integradorService = new IntegradorService();
        $result = $integradorService->update($integrador, $requestData);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Integrador atualizado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(IntegradorResource::class, $result['content']);
    }

    public function testUpdateType()
    {
        // Criar um integrador de exemplo
        $integrador = Integrador::factory()->create();

        // Chamar o método find da IntegradorService
        $integradorService = new IntegradorService();
        $result = $integradorService->updateType($integrador, [
            'tipo' => 'ADMIN'
        ]);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Tipo de integrador atualizado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(IntegradorResource::class, $result['content']);
    }

    public function testDeactive()
    {
        // Criar um integrador de exemplo
        $integrador = Integrador::factory()->create();

        // Chamar o método find da IntegradorService
        $integradorService = new IntegradorService();
        $result = $integradorService->deactive($integrador);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Integrador desativado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(IntegradorResource::class, $result['content']);
    }

    public function testActive()
    {
        // Criar um integrador de exemplo
        $integrador = Integrador::factory()->create();

        // Chamar o método find da IntegradorService
        $integradorService = new IntegradorService();
        $result = $integradorService->active($integrador);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Integrador ativado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(IntegradorResource::class, $result['content']);
    }
}
