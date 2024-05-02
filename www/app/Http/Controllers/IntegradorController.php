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

    /**
     * @OA\Get(
     *   path="/api/integradores",
     *   operationId="getIntegradoresIndex",
     *   tags={"Integradores"},
     *   security={{"sanctum":{}}},
     *   summary="Exibe lista de integradores",
     *   description="",
     *   @OA\Parameter(name="id", description="Filtrar pelo ID", in="query", @OA\Schema(type="integer")),
     *   @OA\Parameter(name="nome", description="Filtrar pelo nome", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="email", description="Filtrar pelo email", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="tipo", description="Filtrar pelo tipo", in="query", @OA\Schema(type="string", enum={"INTEGRADOR", "ADMIN"})),
     *   @OA\Parameter(name="ativo", description="Filtrar pelo status", in="query", @OA\Schema(type="integer", enum={0, 1})),
     *   @OA\Parameter(name="ordenar_id", description="Ordenar pelo ID", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Parameter(name="ordenar_nome", description="Ordenar pelo nome", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Response(
     *       response=200,
     *       description="OK",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Lista de integradores."),
     *           @OA\Property(property="content",type="object",
     *               @OA\Property(property="data", type="array",
     *                  @OA\Items(type="object", ref="#/components/schemas/IntegradorResource"),
     *               ),
     *               @OA\Property(property="meta", type="object", ref="#/components/schemas/CustomPaginator"),
     *           ),
     *           @OA\Property(property="code",type="integer",example="200"),
     *       )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthorized."),
     *   @OA\Response(response=403, description="Forbidden."),
     * )
     */
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

    /**
     * @OA\Post(
     *   path="/api/integradores",
     *   operationId="postIntegradoresStore",
     *   tags={"Integradores"},
     *   security={{"sanctum":{}}},
     *   summary="Cadastra novo integrador",
     *   description="",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/CreateIntegradorRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Integrador cadastrado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/IntegradorResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthorized."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Content.",
     *       @OA\JsonContent(
     *          @OA\Property(property="message",type="string",example="O campo nome é obrigatório. (e mais 1 erro)"),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="nome", type="array",
     *                   @OA\Items(type="string", example="O campo nome é obrigatório.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
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

    /**
     * @OA\Post(
     *   path="/api/auth/login",
     *   operationId="postIntegradoresLogin",
     *   tags={"Login"},
     *   summary="Envie seu e-mail e senha e retornaremos um token. Use o token no cabeçalho 'Authorization' da requisição como 'Bearer TOKEN'",
     *   description="",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/LoginIntegradorRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Login efetuado com sucesso."),
     *        @OA\Property(property="content",type="string",example="99|OOawESyfhebDhYX0LXxnn5as3fV1R3B79uZvH22Ec0df7515"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Content.",
     *       @OA\JsonContent(
     *          @OA\Property(property="message",type="string",example="O campo email é obrigatório. (e mais 1 erro)"),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="email", type="array",
     *                   @OA\Items(type="string", example="O campo email é obrigatório.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
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

    /**
     * @OA\Put(
     *   path="/api/integradores/{id}",
     *   operationId="putIntegradoresUpdate",
     *   tags={"Integradores"},
     *   security={{"sanctum":{}}},
     *   summary="Atualiza os dados do integrador",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do integrador",
     *       example=2,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\RequestBody(required=true,
     *       @OA\JsonContent(ref="#/components/schemas/UpdateIntegradorRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Integrador atualizado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/IntegradorResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Content.",
     *       @OA\JsonContent(
     *          @OA\Property(property="message",type="string",example="O campo email já está sendo utilizado."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="email", type="array",
     *                   @OA\Items(type="string", example="O campo email já está sendo utilizado.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
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

    /**
     * @OA\Patch(
     *   path="/api/integradores/{id}/tipo",
     *   operationId="pathIntegradoresType",
     *   tags={"Integradores"},
     *   security={{"sanctum":{}}},
     *   summary="Atualiza o tipo do integrador",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do integrador",
     *       example=2,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\RequestBody(required=true,
     *       @OA\JsonContent(ref="#/components/schemas/UpdateIntegradorTipoRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Tipo de integrador atualizado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/IntegradorResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Content.",
     *       @OA\JsonContent(
     *          @OA\Property(property="message",type="string",example="O campo tipo selecionado é inválido."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="email", type="array",
     *                   @OA\Items(type="string", example="O campo tipo selecionado é inválido.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
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

    /**
     * @OA\Patch(
     *   path="/api/integradores/{id}/desativar",
     *   operationId="pathIntegradoresDeactive",
     *   tags={"Integradores"},
     *   security={{"sanctum":{}}},
     *   summary="Desativar o integrador",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do integrador",
     *       example=2,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Integrador desativado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/IntegradorResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     * )
     */
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

    /**
     * @OA\Patch(
     *   path="/api/integradores/{id}/ativar",
     *   operationId="pathIntegradoresActive",
     *   tags={"Integradores"},
     *   security={{"sanctum":{}}},
     *   summary="Ativar o integrador",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do integrador",
     *       example=2,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Integrador ativado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/IntegradorResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     * )
     */
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
