<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   title="Requisição para atualizar equipamento",
 *   type="object",
 *   required={"nome"}
 * )
 */
class UpdateEquipamentoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="nome",type="string",example="Estrutura"),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'      => "required|max:100|unique:equipamentos,nome,{$this->equipamento->id}",
        ];
    }
}