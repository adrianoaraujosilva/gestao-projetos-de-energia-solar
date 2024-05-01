<?php

namespace App\Http\Controllers;

use App\Filters\IntegradorFilter;
use App\Http\Requests\CreateIntegradorRequest;
use App\Http\Requests\LoginIntegradorRequest;
use App\Http\Requests\UpdateIntegradorRequest;
use App\Http\Requests\UpdateIntegradorTipoRequest;
use App\Models\Integrador;
use App\Services\IntegradorService;
use Illuminate\Http\JsonResponse;
use Throwable;

class IntegradorController extends Controller
{
    public function index(IntegradorFilter $filters, IntegradorService $integradorService): JsonResponse
    {
        try {
            $listIntegrador = $integradorService->list($filters);

            if ($listIntegrador['status'] === false) {
                return $this->badRequest(message: $listIntegrador['message']);
            }

            return $this->success(
                message: $listIntegrador['message'],
                content: $listIntegrador['content']
            );
        } catch (\Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function store(CreateIntegradorRequest $createIntegradorRequest, IntegradorService $integradorService): JsonResponse
    {
        try {
            $createIntegrador = $integradorService->create($createIntegradorRequest->validated());

            if ($createIntegrador['status'] === false) {
                return $this->badRequest(message: $createIntegrador['message']);
            }

            return $this->success(
                message: $createIntegrador['message'],
                content: $createIntegrador['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function login(LoginIntegradorRequest $loginIntegradorRequest, IntegradorService $integradorService): JsonResponse
    {
        try {
            $tokenIntegrador = $integradorService->login($loginIntegradorRequest->validated());

            if ($tokenIntegrador['status'] === false) {
                return $this->unauthorized();
            }

            return $this->success(
                message: $tokenIntegrador['message'],
                content: $tokenIntegrador['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function update(Integrador $integrador, UpdateIntegradorRequest $updateIntegradorRequest, IntegradorService $integradorService): JsonResponse
    {
        try {
            $updateIntegrador = $integradorService->update($integrador, $updateIntegradorRequest->validated());

            if ($updateIntegrador['status'] === false) {
                return $this->badRequest(message: $updateIntegrador['message']);
            }

            return $this->success(
                message: $updateIntegrador['message'],
                content: $updateIntegrador['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function type(Integrador $integrador, UpdateIntegradorTipoRequest $updateIntegradorTipoRequest, IntegradorService $integradorService): JsonResponse
    {
        try {
            $updateTypeIntegrador = $integradorService->updateType($integrador, $updateIntegradorTipoRequest->validated());

            if ($updateTypeIntegrador['status'] === false) {
                return $this->badRequest(message: $updateTypeIntegrador['message']);
            }

            return $this->success(
                message: $updateTypeIntegrador['message'],
                content: $updateTypeIntegrador['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function deactive(Integrador $integrador, IntegradorService $integradorService): JsonResponse
    {
        try {
            $deactiveIntegrador = $integradorService->deactive($integrador);

            if ($deactiveIntegrador['status'] === false) {
                return $this->badRequest(message: $deactiveIntegrador['message']);
            }

            return $this->success(
                message: $deactiveIntegrador['message'],
                content: $deactiveIntegrador['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function active(Integrador $integrador, IntegradorService $integradorService): JsonResponse
    {
        try {
            $activeIntegrador = $integradorService->active($integrador);

            if ($activeIntegrador['status'] === false) {
                return $this->badRequest(message: $activeIntegrador['message']);
            }

            return $this->success(
                message: $activeIntegrador['message'],
                content: $activeIntegrador['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }
}
