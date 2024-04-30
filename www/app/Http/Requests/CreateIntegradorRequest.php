<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateIntegradorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'      => 'required|string',
            'email'     => 'required|email|unique:integradores',
            'password'  => 'required|confirmed',
            'tipo'      => 'required|in:ADMIN,INTEGRADOR'
        ];
    }
}
