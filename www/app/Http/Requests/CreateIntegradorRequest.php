<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   title="Requisição para gravar integrador",
 *   type="object",
 *   required={"nome", "email", "tipo", "password", "password_confirmation"}
 * )
 */
class CreateIntegradorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="nome",type="string",example="admin@admin.com"),
     * @OA\Property(property="email",type="string",example="admin@admin.com"),
     * @OA\Property(property="tipo",type="string",example="INTEGRADOR"),
     * @OA\Property(property="password",type="string",example="Admin@123"),
     * @OA\Property(property="password_confirmation",type="string",example="Admin@123"),
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
