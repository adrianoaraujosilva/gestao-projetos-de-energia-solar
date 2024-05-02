<?php

namespace App\Http\Controllers;

use App\Filters\ClienteFilter;
use App\Http\Requests\CreateClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use Throwable;

class ClienteController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/clientes",
     *   operationId="getClientesIndex",
     *   tags={"Clientes"},
     *   security={{"sanctum":{}}},
     *   summary="Exibe lista de clientes",
     *   description="",
     *   @OA\Parameter(name="id", description="Filtrar pelo ID", in="query", @OA\Schema(type="integer")),
     *   @OA\Parameter(name="nome", description="Filtrar pelo nome", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="email", description="Filtrar pelo email", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="telefone", description="Filtrar pelo telefone", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="cpf_cnpj", description="Filtrar pelo CPF/CNPJ", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="ordenar_id", description="Ordenar pelo ID", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Parameter(name="ordenar_nome", description="Ordenar pelo nome", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Response(
     *       response=200,
     *       description="OK",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Lista de clientes."),
     *           @OA\Property(property="content",type="object",
     *               @OA\Property(property="data", type="array",
     *                  @OA\Items(type="object", ref="#/components/schemas/ClienteResource"),
     *               ),
     *               @OA\Property(property="meta", type="object", ref="#/components/schemas/CustomPaginator"),
     *           ),
     *           @OA\Property(property="code",type="integer",example="200"),
     *       )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthorized."),
     *   @OA\Response(response=403, description="Forbidden."),
     * )
     */
    public function index(ClienteFilter $filters, ClienteService $clienteService): JsonResponse
    {
        try {
            $listClientes = $clienteService->list($filters);

            if ($listClientes['status'] === false) {
                return $this->badRequest(message: $listClientes['message']);
            }

            return $this->success(
                message: $listClientes['message'],
                content: $listClientes['content']
            );
        } catch (\Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Post(
     *   path="/api/clientes",
     *   operationId="postClientesStore",
     *   tags={"Clientes"},
     *   security={{"sanctum":{}}},
     *   summary="Cadastra novo cliente",
     *   description="",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/CreateClienteRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Cliente cadastrado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/ClienteResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthorized."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Content.",
     *       @OA\JsonContent(
     *          @OA\Property(property="message",type="string",example="O campo cpf cnpj não é um CPF ou CNPJ válido."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="nome", type="array",
     *                   @OA\Items(type="string", example="O campo cpf cnpj não é um CPF ou CNPJ válido.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
    public function store(CreateClienteRequest $createClientRequest, ClienteService $clienteService): JsonResponse
    {
        try {
            $createCliente = $clienteService->create($createClientRequest->validated());

            if ($createCliente['status'] === false) {
                return $this->badRequest(message: $createCliente['message']);
            }

            return $this->success(
                message: $createCliente['message'],
                content: $createCliente['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Get(
     *   path="/api/clientes/{id}",
     *   operationId="getClientesShow",
     *   tags={"Clientes"},
     *   security={{"sanctum":{}}},
     *   summary="Pesquisa cliente pelo ID",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do cliente",
     *       example=2,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Cliente ID: 2"),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/ClienteResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     * )
     */
    public function show(Cliente $cliente, ClienteService $clienteService)
    {
        try {
            $findCliente = $clienteService->find($cliente);

            if ($findCliente['status'] === false) {
                return $this->badRequest(message: $findCliente['message']);
            }

            return $this->success(
                message: $findCliente['message'],
                content: $findCliente['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Put(
     *   path="/api/clientes/{id}",
     *   operationId="putClientesUpdate",
     *   tags={"Clientes"},
     *   security={{"sanctum":{}}},
     *   summary="Atualiza os dados do cliente",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do cliente",
     *       example=2,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\RequestBody(required=true,
     *       @OA\JsonContent(ref="#/components/schemas/UpdateClienteRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Cliente atualizado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/ClienteResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Content.",
     *       @OA\JsonContent(
     *          @OA\Property(property="message",type="string",example="O campo cpf cnpj não é um CPF ou CNPJ válido."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="email", type="array",
     *                   @OA\Items(type="string", example="O campo cpf cnpj não é um CPF ou CNPJ válido.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
    public function update(Cliente $cliente, UpdateClienteRequest $updateClienteRequest, ClienteService $clienteService)
    {
        try {
            $updateCliente = $clienteService->update($cliente, $updateClienteRequest->validated());

            if ($updateCliente['status'] === false) {
                return $this->badRequest(message: $updateCliente['message']);
            }

            return $this->success(
                message: $updateCliente['message'],
                content: $updateCliente['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }
}
