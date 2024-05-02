<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   title="Retornoadados do integrador",
 *   type="object",
 * )
 */
class IntegradorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Property(property="id",type="integer",example=1),
     * @OA\Property(property="nome",type="string",example="Admin"),
     * @OA\Property(property="email",type="string",example="admin@admin.com"),
     * @OA\Property(property="tipo",type="string",example="INTEGRADOR"),
     * @OA\Property(property="ativo",type="boolean",example=true),
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
            'email'         => $this->email,
            'tipo'          => $this->tipo,
            'ativo'         => $this->ativo,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
