<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'     => "required|email|unique:clientes,email,{$this->cliente->id}",
            'nome'      => 'required|max:100',
            'telefone'  => 'required|celular_com_ddd',
            'cpf_cnpj'  => "required|cpf_ou_cnpj|unique:clientes,cpf_cnpj,{$this->cliente->id}"
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf_cnpj' => preg_replace('/\D/', '', $this->cpf_cnpj),
        ]);
    }
}
