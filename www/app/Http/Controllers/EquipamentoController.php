<?php

namespace App\Http\Controllers;

use App\Filters\EquipamentoFilter;
use App\Http\Requests\CreateEquipamentoRequest;
use App\Http\Requests\UpdateEquipamentoRequest;
use App\Models\Equipamento;
use App\Services\EquipamentoService;
use Illuminate\Http\JsonResponse;
use Throwable;

class EquipamentoController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/equipamentos",
     *   operationId="getEquipamentosIndex",
     *   tags={"Equipamentos"},
     *   security={{"sanctum":{}}},
     *   summary="Exibe lista de equipamentos",
     *   description="",
     *   @OA\Parameter(name="id", description="Filtrar pelo ID", in="query", @OA\Schema(type="integer")),
     *   @OA\Parameter(name="nome", description="Filtrar pelo nome", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="ordenar_id", description="Ordenar pelo ID", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Parameter(name="ordenar_nome", description="Ordenar pelo nome", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Response(
     *       response=200,
     *       description="OK",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Lista de equipamentos."),
     *           @OA\Property(property="content",type="object",
     *               @OA\Property(property="data", type="array",
     *                  @OA\Items(type="object", ref="#/components/schemas/EquipamentoResource"),
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
    public function index(EquipamentoFilter $filters, EquipamentoService $equipamentoService): JsonResponse
    {
        try {
            $listEquipamentos = $equipamentoService->list($filters);

            if ($listEquipamentos['status'] === false) {
                return $this->badRequest(message: $listEquipamentos['message']);
            }

            return $this->success(
                message: $listEquipamentos['message'],
                content: $listEquipamentos['content']
            );
        } catch (\Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Post(
     *   path="/api/equipamentos",
     *   operationId="postEquipamentosStore",
     *   tags={"Equipamentos"},
     *   security={{"sanctum":{}}},
     *   summary="Cadastra novo equipamento (Somente integrador do tipo 'ADMIN')",
     *   description="",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/CreateEquipamentoRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Equipamento cadastrado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/EquipamentoResource"),
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
    public function store(CreateEquipamentoRequest $createEquipamentoRequest, EquipamentoService $equipamentoService): JsonResponse
    {
        try {
            $createEquipamento = $equipamentoService->create($createEquipamentoRequest->validated());

            if ($createEquipamento['status'] === false) {
                return $this->badRequest(message: $createEquipamento['message']);
            }

            return $this->success(
                message: $createEquipamento['message'],
                content: $createEquipamento['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Get(
     *   path="/api/equipamentos/{id}",
     *   operationId="getEquipamentosShow",
     *   tags={"Equipamentos"},
     *   security={{"sanctum":{}}},
     *   summary="Pesquisa equipamento pelo ID",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do equipamento",
     *       example=1,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Equipamento ID: 2"),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/EquipamentoResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     * )
     */
    public function show(Equipamento $equipamento, EquipamentoService $equipamentoService)
    {
        try {
            $findEquipamento = $equipamentoService->find($equipamento);

            if ($findEquipamento['status'] === false) {
                return $this->badRequest(message: $findEquipamento['message']);
            }

            return $this->success(
                message: $findEquipamento['message'],
                content: $findEquipamento['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Put(
     *   path="/api/equipamentos/{id}",
     *   operationId="putEquipamentosUpdate",
     *   tags={"Equipamentos"},
     *   security={{"sanctum":{}}},
     *   summary="Atualiza os dados da Equipamento (Somente integrador do tipo 'ADMIN')",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID da Equipamento",
     *       example=1,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\RequestBody(required=true,
     *       @OA\JsonContent(ref="#/components/schemas/UpdateEquipamentoRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Equipamento atualizado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/EquipamentoResource"),
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
    public function update(Equipamento $equipamento, UpdateEquipamentoRequest $updateEquipamentoRequest, EquipamentoService $equipamentoService)
    {
        try {
            $updateEquipamento = $equipamentoService->update($equipamento, $updateEquipamentoRequest->validated());

            if ($updateEquipamento['status'] === false) {
                return $this->badRequest(message: $updateEquipamento['message']);
            }

            return $this->success(
                message: $updateEquipamento['message'],
                content: $updateEquipamento['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }
}
