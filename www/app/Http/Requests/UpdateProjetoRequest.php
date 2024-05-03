<?php

namespace App\Http\Requests;

use App\Models\Projeto;
use App\Rules\ExistsUniqueByActionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *   title="Requisição para atualizar projeto",
 *   type="object",
 * )
 */
class UpdateProjetoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="nome",type="string",example="Projeto 01"),
     * @OA\Property(property="cliente_id",type="integer",example=1),
     * @OA\Property(property="uf",type="string",enum={"SP", "MG"}),
     * @OA\Property(property="instalacao_id",type="integer",example=1),
     * @OA\Property(property="equipamentos",type="array",
     *   @OA\Items(type="object",
     *       @OA\Property(property="equipamento_id",type="integer",example=1),
     *       @OA\Property(property="quantidade",type="number",example=10.5),
     *       @OA\Property(property="descricao",type="string",example="Fios vermelhos para o positivo do sistema On-Grid"),
     *       @OA\Property(property="acao",type="string",enum={"C", "U", "D"}),
     *   ),
     * ),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'                          => 'max:100',
            'cliente_id'                    => 'exists:clientes,id',
            'uf'                            => Rule::in(Projeto::UF),
            'instalacao_id'                 => 'exists:instalacoes,id',
            'equipamentos'                  => 'array',
            'equipamentos.*.equipamento_id' => [
                'required',
                'distinct',
                'exists:equipamentos,id',
                new ExistsUniqueByActionRule(),
            ],
            'equipamentos.*.quantidade'     => 'required_if:equipamentos.*.acao,C|numeric|between:0.001,99999.9999',
            'equipamentos.*.descricao'      => 'nullable|string|max:255',
            'equipamentos.*.acao'           => 'required|in:C,U,D',
        ];
    }
}
