<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   title="Requisição para gravar cliente",
 *   type="object",
 *   required={"nome", "email", "telefone", "cpf_cnpj"}
 * )
 */
class CreateClienteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="nome",type="string",example="Cliente 01"),
     * @OA\Property(property="email",type="string",example="cliente-01@admin.com"),
     * @OA\Property(property="telefone",type="string",example="(11) 99999-9990"),
     * @OA\Property(property="cpf_cnpj",type="string",example="999.999.999-99"),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'          => 'required|max:100',
            'email'         => "required|email|unique:clientes,email,null,null,integrador_id,{$this->user()->id}",
            'telefone'      => 'required|celular_com_ddd',
            'cpf_cnpj'      => "required|cpf_ou_cnpj|unique:clientes,cpf_cnpj,null,null,integrador_id,{$this->user()->id}",
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf_cnpj'      => preg_replace('/\D/', '', $this->cpf_cnpj),
        ]);
    }
}
