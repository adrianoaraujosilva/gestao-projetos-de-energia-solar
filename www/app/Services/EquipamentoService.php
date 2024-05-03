<?php

namespace App\Services;

use App\Filters\EquipamentoFilter;
use App\Http\Resources\EquipamentoResource;
use App\Models\Equipamento;
use App\Traits\ServiceResponse;

class EquipamentoService
{
    use ServiceResponse;

    public function findAll(EquipamentoFilter $filters): array
    {
        return $this->response(
            message: 'Lista de equipamentos.',
            content: Equipamento::filter($filters)
                ->paginate()
        );
    }

    public function create(array $request): array
    {
        $createEquipamento = Equipamento::create($request);

        return $this->response(
            message: 'Equipamento cadastrada com sucesso.',
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
        $updateEquipamento = tap($equipamento)->update($request);

        return $this->response(
            message: 'Equipamento atualizado com sucesso.',
            content: new EquipamentoResource($updateEquipamento)
        );
    }
}
