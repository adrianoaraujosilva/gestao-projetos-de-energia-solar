<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginIntegradorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
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
