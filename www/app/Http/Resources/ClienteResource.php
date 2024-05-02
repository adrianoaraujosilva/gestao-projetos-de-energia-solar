<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   title="Retorna dados do cliente",
 *   type="object",
 * )
 */
class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Property(property="id",type="integer",example=1),
     * @OA\Property(property="integrador",type="object", ref="#/components/schemas/IntegradorResource"),
     * @OA\Property(property="nome",type="string",example="Integrador-01"),
     * @OA\Property(property="email",type="string",example="integrador-01@admin.com"),
     * @OA\Property(property="telefone",type="string",example="(11) 99999-9990"),
     * @OA\Property(property="cpf_cnpj",type="string",example="99999999999"),
     * @OA\Property(property="created_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     * @OA\Property(property="updated_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'integrador'    => new IntegradorResource($this->integrador),
            'nome'          => $this->nome,
            'email'         => $this->email,
            'telefone'      => $this->telefone,
            'cpf_cnpj'      => $this->cpf_cnpj,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
