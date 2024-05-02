<?php

namespace App\Services;

use App\Filters\InstalacaoFilter;
use App\Http\Resources\InstalacaoResource;
use App\Models\Instalacao;
use App\Traits\ServiceResponse;

class InstalacaoService
{
    use ServiceResponse;

    public function list(InstalacaoFilter $filters): array
    {
        return $this->response(
            message: 'Lista de Instalações.',
            content: Instalacao::filter($filters)
                ->paginate()
        );
    }

    public function create(array $request): array
    {
        $createInstalacao = Instalacao::create($request);

        return $this->response(
            message: 'Instalação cadastrada com sucesso.',
            content: new InstalacaoResource($createInstalacao)
        );
    }

    public function find(Instalacao $instalacao): array
    {
        return $this->response(
            message: "Instalação ID: {$instalacao->id}.",
            content: new InstalacaoResource($instalacao)
        );
    }

    public function update(Instalacao $instalacao, array $request): array
    {
        $updateInstalacao = tap($instalacao)->update($request);

        return $this->response(
            message: 'Instalacao atualizado com sucesso.',
            content: new InstalacaoResource($updateInstalacao)
        );
    }
}
