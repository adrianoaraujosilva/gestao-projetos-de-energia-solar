<?php

namespace App\Http\Controllers;

use App\Filters\InstalacaoFilter;
use App\Http\Requests\CreateInstalacaoRequest;
use App\Http\Requests\UpdateInstalacaoRequest;
use App\Models\Instalacao;
use App\Services\InstalacaoService;
use Illuminate\Http\JsonResponse;
use Throwable;

class InstalacaoController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/instalacoes",
     *   operationId="getInstalacoesIndex",
     *   tags={"Instalações"},
     *   security={{"sanctum":{}}},
     *   summary="Exibe lista de instalação",
     *   description="",
     *   @OA\Parameter(name="id", description="Filtrar pelo ID", in="query", @OA\Schema(type="integer")),
     *   @OA\Parameter(name="nome", description="Filtrar pelo nome", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="ordenar_id", description="Ordenar pelo ID", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Parameter(name="ordenar_nome", description="Ordenar pelo nome", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Response(
     *       response=200,
     *       description="OK",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Lista de instalações."),
     *           @OA\Property(property="content",type="object",
     *               @OA\Property(property="data", type="array",
     *                  @OA\Items(type="object", ref="#/components/schemas/InstalacaoResource"),
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
    public function index(InstalacaoFilter $filters, InstalacaoService $instalacaoService): JsonResponse
    {
        try {
            $listInstalacoes = $instalacaoService->findAll($filters);

            if ($listInstalacoes['status'] === false) {
                return $this->badRequest(message: $listInstalacoes['message']);
            }

            return $this->success(
                message: $listInstalacoes['message'],
                content: $listInstalacoes['content']
            );
        } catch (\Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Post(
     *   path="/api/instalacoes",
     *   operationId="postInstalacoesStore",
     *   tags={"Instalações"},
     *   security={{"sanctum":{}}},
     *   summary="Cadastra nova instalação (Somente integrador do tipo 'ADMIN')",
     *   description="",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/CreateInstalacaoRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Instalação cadastrada com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/InstalacaoResource"),
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
     *          @OA\Property(property="message",type="string",example="O campo nome já está sendo utilizado."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="nome", type="array",
     *                   @OA\Items(type="string", example="O campo nome já está sendo utilizado.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
    public function store(CreateInstalacaoRequest $createInstalacaoRequest, InstalacaoService $instalacaoService): JsonResponse
    {
        try {
            $createInstalacao = $instalacaoService->create($createInstalacaoRequest->validated());

            if ($createInstalacao['status'] === false) {
                return $this->badRequest(message: $createInstalacao['message']);
            }

            return $this->success(
                message: $createInstalacao['message'],
                content: $createInstalacao['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Get(
     *   path="/api/instalacoes/{id}",
     *   operationId="getInstalacoesShow",
     *   tags={"Instalações"},
     *   security={{"sanctum":{}}},
     *   summary="Pesquisa instalação pelo ID",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID da instalação",
     *       example=1,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Instalação ID: 2"),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/InstalacaoResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     * )
     */
    public function show(Instalacao $instalacao, InstalacaoService $instalacaoService)
    {
        try {
            $findInstalacao = $instalacaoService->find($instalacao);

            if ($findInstalacao['status'] === false) {
                return $this->badRequest(message: $findInstalacao['message']);
            }

            return $this->success(
                message: $findInstalacao['message'],
                content: $findInstalacao['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Put(
     *   path="/api/instalacoes/{id}",
     *   operationId="putInstalacoesUpdate",
     *   tags={"Instalações"},
     *   security={{"sanctum":{}}},
     *   summary="Atualiza os dados da instalação (Somente integrador do tipo 'ADMIN')",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID da instalação",
     *       example=1,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\RequestBody(required=true,
     *       @OA\JsonContent(ref="#/components/schemas/UpdateInstalacaoRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Instalação atualizada com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/InstalacaoResource"),
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
     *          @OA\Property(property="message",type="string",example="O campo nome já está sendo utilizado."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="email", type="array",
     *                   @OA\Items(type="string", example="O campo nome já está sendo utilizado.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
    public function update(Instalacao $instalacao, UpdateInstalacaoRequest $updateInstalacaoRequest, InstalacaoService $instalacaoService)
    {
        try {
            $updateInstalacao = $instalacaoService->update($instalacao, $updateInstalacaoRequest->validated());

            if ($updateInstalacao['status'] === false) {
                return $this->badRequest(message: $updateInstalacao['message']);
            }

            return $this->success(
                message: $updateInstalacao['message'],
                content: $updateInstalacao['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }
}
