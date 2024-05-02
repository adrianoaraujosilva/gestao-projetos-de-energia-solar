<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   title="Requisição para gravar instalação",
 *   type="object",
 *   required={"nome"}
 * )
 */
class CreateInstalacaoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="nome",type="string",example="Metálico"),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'          => 'required|max:100|unique:instalacoes',
        ];
    }
}
