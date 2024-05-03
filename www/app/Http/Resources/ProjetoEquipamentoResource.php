<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *   title="Retorna dados dos equipamentos do projeto",
 *   type="object",
 * )
 */
class ProjetoEquipamentoResource extends ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @OA\Property(property="id",type="integer",example=1),
     * @OA\Property(property="nome",type="string", example="Módulo"),
     * @OA\Property(property="quantidade",type="numeric", example=15.05),
     * @OA\Property(property="descricao",type="string", example="Fios vermelhos para o positivo do sistema On-Grid"),
     * @OA\Property(property="created_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     * @OA\Property(property="updated_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        foreach ($this as $key => $equipamento) {
            $data[$key] = [
                'id'    => $equipamento->id,
                'nome'              => $equipamento->nome,
                'quantidade'        => $equipamento->pivot->quantidade,
                'descricacao'       => $equipamento->pivot->descricao,
                'created_at'        => $equipamento->created_at,
                'updated_at'        => $equipamento->updated_at,
            ];
        }

        return $data;
    }
}
