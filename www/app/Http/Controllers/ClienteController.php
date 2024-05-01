<?php

namespace App\Http\Controllers;

use App\Filters\ClienteFilter;
use App\Http\Requests\CreateClienteRequest;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use Throwable;

class ClienteController extends Controller
{
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
