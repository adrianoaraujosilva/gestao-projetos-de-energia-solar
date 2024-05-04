<?php

namespace App\Services;

use App\Filters\EquipamentoFilter;
use App\Http\Resources\EquipamentoResource;
use App\Models\Equipamento;
use App\Traits\ServiceResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class EquipamentoService
{
    use ServiceResponse;

    public function findAll(EquipamentoFilter $filters): array
    {
        return $this->response(
            message: 'Lista de Equipamentos.',
            content: Equipamento::filter($filters)
                ->paginate()
        );
    }

    public function create(array $request): array
    {
        $createEquipamento = Equipamento::create($request);

        return $this->response(
            message: 'Equipamento cadastrado com sucesso.',
            content: new EquipamentoResource($createEquipamento)
        );
    }

    public function find(Equipamento $equipamento): array
    {
        return $this->response(
            message: "Equipamento ID: {$equipamento->id}",
            content: new EquipamentoResource($equipamento)
        );
    }

    public function update(Equipamento $equipamento, array $request): array
    {
        try {
            Equipamento::findOrFail($equipamento->id ?? null);

            $updateEquipamento = tap($equipamento)->update($request);

            return $this->response(
                message: 'Equipamento atualizado com sucesso.',
                content: new EquipamentoResource($updateEquipamento)
            );
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return $this->response(status: false, message: "Equipamento não encontrado.");
        }
    }
}
