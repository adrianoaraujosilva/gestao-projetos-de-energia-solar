<?php

namespace App\Services;

use App\Filters\IntegradorFilter;
use App\Http\Resources\IntegradorResource;
use App\Models\Integrador;
use App\Traits\ServiceResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class IntegradorService
{
    use ServiceResponse;

    public function list(IntegradorFilter $filters): array
    {
        return $this->response(
            message: 'Lista de integradores.',
            content: Integrador::filter($filters)->paginate()
        );
    }

    public function create(array $request): array
    {
        $createIntegrador = Integrador::create($request);

        return $this->response(
            message: 'Integrador cadastrado com sucesso.',
            content: new IntegradorResource($createIntegrador)
        );
    }

    public function login(array $request): array
    {
        if (Auth::attempt($request) && auth()->user()->isActive()) {
            return $this->response(
                message: 'Login efetuado com sucesso.',
                content: auth()->user()->createToken("API TOKEN")->plainTextToken
            );
        }

        return $this->response(
            status: false,
            message: "Unauthenticated."
        );
    }

    public function update(Integrador $integrador, array $request): array
    {
        $updateIntegrador = tap($integrador)->update(Arr::only($request, [
            'nome',
            'email',
            'password',
        ]));

        return $this->response(
            message: 'Integrador atualizado com sucesso.',
            content: new IntegradorResource($updateIntegrador)
        );
    }

    public function updateType(Integrador $integrador, array $request): array
    {
        $updateTipoIntegrador = tap($integrador)->update(Arr::only($request, [
            'tipo'
        ]));

        return $this->response(
            message: 'Tipo de integrador atualizado com sucesso.',
            content: new IntegradorResource($updateTipoIntegrador)
        );
    }

    public function deactive(Integrador $integrador): array
    {
        $integrador->tokens()->delete();

        return $this->response(
            message: 'Integrador desativado com sucesso.',
            content: new IntegradorResource(tap($integrador)->update([
                "ativo" => false
            ]))
        );
    }

    public function active(Integrador $integrador): array
    {
        return $this->response(
            message: 'Integrador ativado com sucesso.',
            content: new IntegradorResource(tap($integrador)->update([
                "ativo" => true
            ]))
        );
    }
}
