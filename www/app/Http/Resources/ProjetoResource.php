<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   title="Retorna dados do projeto",
 *   type="object",
 * )
 */
class ProjetoResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @OA\Property(property="id",type="integer",example=1),
     * @OA\Property(property="cliente",type="object", ref="#/components/schemas/ClienteResource"),
     * @OA\Property(property="nome",type="string",example="Integrador-01"),
     * @OA\Property(property="uf",type="string",enum={"SP", "MG"}),
     * @OA\Property(property="instalacao",type="object", ref="#/components/schemas/InstalacaoResource"),
     * @OA\Property(property="equipamentos",type="array",
     *   @OA\Items(type="object", ref="#/components/schemas/ProjetoEquipamentoResource")
     * ),
     * @OA\Property(property="created_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     * @OA\Property(property="updated_at",type="string",example="2024-04-30T23:29:52.000000Z"),
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'cliente'       => new ClienteResource($this->cliente),
            'nome'          => $this->nome,
            'uf'            => $this->uf,
            'instalacao'    => new InstalacaoResource($this->instalacao),
            'equipamentos'  => new ProjetoEquipamentoResource($this->equipamentos),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
