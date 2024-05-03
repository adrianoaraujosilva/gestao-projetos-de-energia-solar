<?php

namespace App\Services;

use App\Filters\ClienteFilter;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use App\Traits\ServiceResponse;
use Illuminate\Support\Arr;

class ClienteService
{
    use ServiceResponse;

    public function findAll(ClienteFilter $filters): array
    {
        return $this->response(
            message: 'Lista de Clientes.',
            content: Cliente::with('integrador')
                ->filter($filters)
                ->paginate()
        );
    }

    public function create(array $request): array
    {
        $createCliente = Cliente::with('integrador')
            ->create(
                Arr::except($request, 'integrador_id')
            );

        return $this->response(
            message: 'Cliente cadastrado com sucesso.',
            content: new ClienteResource($createCliente)
        );
    }

    public function find(Cliente $cliente): array
    {
        return $this->response(
            message: "Cliente ID: {$cliente->id}",
            content: new ClienteResource($cliente->loadMissing('integrador'))
        );
    }

    public function update(Cliente $cliente, array $request): array
    {
        $updateCliente = tap($cliente->loadMissing('integrador'))
            ->update(
                Arr::except($request, 'integrador_id')
            );

        return $this->response(
            message: 'Cliente atualizado com sucesso.',
            content: new ClienteResource($updateCliente)
        );
    }
}
