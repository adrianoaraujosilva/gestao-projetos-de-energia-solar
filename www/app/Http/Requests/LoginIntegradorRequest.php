<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   title="Requisição para efetuar login",
 *   type="object",
 *   required={"email", "password"}
 * )
 */
class LoginIntegradorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="email",type="string",example="admin@admin.com"),
     * @OA\Property(property="password",type="string",example="Admin@123"),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'     => 'required|email',
            'password'  => 'required|string'
        ];
    }
}
