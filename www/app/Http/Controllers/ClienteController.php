<?php

namespace App\Http\Controllers;

use App\Filters\ClienteFilter;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\IndexClienteResource;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ClienteController extends Controller
{
    public function index(ClienteFilter $filters): JsonResponse
    {
        try {
            return $this->success(
                message: 'Lista de clientes',
                content: Cliente::filter($filters)->paginate()
            );
        } catch (\Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function store(StoreClienteRequest $storeClientRequest): JsonResponse
    {
        try {
            return $this->success(
                message: 'Cliente cadastrado com sucesso',
                content: new ClienteResource(Cliente::create($storeClientRequest->validated()))
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function show(Cliente $cliente)
    {
        try {
            return $this->success(
                message: "Cliente ID: {$cliente->id}",
                content: new ClienteResource($cliente)
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function update(Cliente $cliente, UpdateClienteRequest $updateClienteRequest)
    {
        try {
            return $this->success(
                message: 'Cliente atualizado com sucesso',
                content: new ClienteResource(tap($cliente)->update($updateClienteRequest->validated()))
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }
}
