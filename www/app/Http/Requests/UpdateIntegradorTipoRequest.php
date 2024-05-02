<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   title="Requisição para atualizar tipo do integrador",
 *   type="object",
 * )
 */
class UpdateIntegradorTipoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="tipo",type="string", enum={"INTEGRADOR", "ADMIN"}),
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo'  => 'required|in:ADMIN,INTEGRADOR'
        ];
    }
}
