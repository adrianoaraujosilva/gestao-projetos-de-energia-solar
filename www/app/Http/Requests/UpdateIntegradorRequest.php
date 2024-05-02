<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   title="Requisição para atualizar integrador",
 *   type="object",
 * )
 */
class UpdateIntegradorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin() || $this->integrador->id === auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="nome",type="string",example="integrador-01"),
     * @OA\Property(property="email",type="string",example="integrador-01@admin.com"),
     * @OA\Property(property="password",type="string",example="Admin@123"),
     * @OA\Property(property="password_confirmation",type="string",example="Admin@123"),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'      => 'string',
            'email'     => "email|unique:integradores,email,{$this->integrador->id}",
            'password'  => 'confirmed',
        ];
    }
}
