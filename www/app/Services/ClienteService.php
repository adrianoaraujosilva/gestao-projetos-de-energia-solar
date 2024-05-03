<?php

namespace App\Services;

use App\Filters\ClienteFilter;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use App\Traits\ServiceResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        try {
            Cliente::findOrFail($cliente->id ?? null);
            $updateCliente = tap($cliente->loadMissing('integrador'))
                ->update(
                    Arr::except($request, 'integrador_id')
                );

            return $this->response(
                message: 'Cliente atualizado com sucesso.',
                content: new ClienteResource($updateCliente)
            );
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return $this->response(status: false, message: "Cliente não encontrado.");
        }
    }
}
