<?php

namespace Tests\Unit;

use App\Filters\ClienteFilter;
use App\Http\Resources\ClienteResource;
use Tests\TestCase;

use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ClienteServiceTest extends TestCase
{

    public function testFindAll(): void
    {
        // Criar alguns clientes de exemplo
        Cliente::factory(5)->create();

        // Cria uma requisição simples para ordenar por ia
        $request = new Request(['ordenar_id' => 'asc']);

        // Criar uma instância de ClienteFilter
        $filters = new ClienteFilter($request);

        // Chamar o método findAll da ClienteService
        $clienteService = new ClienteService();
        $result = $clienteService->findAll($filters);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Lista de Clientes.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result['content']);
    }

    public function testCreate()
    {
        // Força autenticação do usuário 1
        Auth::loginUsingId(1);

        // Gerar dados de cliente de exemplo
        $cliente = Cliente::factory()->make()->toArray();

        // Chamar o método create da ClienteService
        $clienteService = new ClienteService();
        $result = $clienteService->create($cliente);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Cliente cadastrado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(ClienteResource::class, $result['content']);
    }

    public function testFind()
    {
        // Criar um cliente de exemplo
        $cliente = Cliente::factory()->create();

        // Chamar o método find da ClienteService
        $clienteService = new ClienteService();
        $result = $clienteService->find($cliente);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals("Cliente ID: {$cliente->id}", $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(ClienteResource::class, $result['content']);
    }

    public function testUpdate()
    {
        // Criar um cliente de exemplo
        $cliente = Cliente::factory()->create();

        // Gerar dados de atualização de cliente de exemplo
        $requestData = Cliente::factory()->make()->toArray();

        // Chamar o método update da ClienteService
        $clienteService = new ClienteService();
        $result = $clienteService->update($cliente, $requestData);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Cliente atualizado com sucesso.', $result['message']);
        $this->assertArrayHasKey('content', $result);
        $this->assertInstanceOf(ClienteResource::class, $result['content']);
    }

    public function testCreateValidationErrors()
    {
        // Força autenticação do usuário 1
        Auth::loginUsingId(1);

        // Simular uma chamada ao método create com dados inválidos
        $requestData = [
            'nome' => '', // Nome vazio
            'email' => 'email_invalido', // E-mail inválido
            'telefone' => '12345', // Telefone com menos de 8 dígitos
            'cpf_cnpj' => '123456789', // CPF/CNPJ com menos de 11 dígitos
        ];

        // Chamar o método create da ClienteService
        $clienteService = new ClienteService();
        $result = $clienteService->create($requestData);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Erro ao cadastrar cliente.', $result['message']);
        $this->assertArrayHasKey('errors', $result);
    }

    public function testUpdateNotFound()
    {
        // Criar um cliente de exemplo
        $cliente = new Cliente();

        // Chamar o método update da ClienteService com um ID inexistente
        $clienteService = new ClienteService();
        $result = $clienteService->update($cliente, []);

        // Verificar se o resultado possui a estrutura correta
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Cliente não encontrado.', $result['message']);
    }
}
