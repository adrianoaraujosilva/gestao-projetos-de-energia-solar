<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   title="Retorna dados do equipamento",
 *   type="object",
 * )
 */
class EquipamentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Property(property="id",type="integer",example=1),
     * @OA\Property(property="nome",type="string",example="Estrutura"),
     * @OA\Property(property="created_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     * @OA\Property(property="updated_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nome'          => $this->nome,
        ];
    }
}
