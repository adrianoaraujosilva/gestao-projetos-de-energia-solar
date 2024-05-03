<?php

namespace App\Http\Requests;

use App\Models\Projeto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *   title="Requisição para gravar projeto",
 *   type="object",
 *   required={"nome", "cliente_id", "uf", "instalacao_id", "equipamentos", "equipamentos.equipamento_id", "equipamentos.quantidade", "equipamentos.descricao"}
 * )
 */
class CreateProjetoRequest extends FormRequest
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
     *   ),
     * ),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'                          => 'required|max:100',
            'cliente_id'                    => "required|exists:clientes,id,integrador_id,{$this->user()->id}",
            'uf'                            => ['required', Rule::in(Projeto::UF)],
            'instalacao_id'                 => 'required|exists:instalacoes,id',
            'equipamentos'                  => 'required|array',
            'equipamentos.*.equipamento_id' => 'required|distinct|exists:equipamentos,id',
            'equipamentos.*.quantidade'     => 'required|numeric|between:0.001,99999.9999',
            'equipamentos.*.descricao'      => 'nullable|string|max:255',
        ];
    }
}
