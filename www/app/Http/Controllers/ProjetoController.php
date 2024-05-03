<?php

namespace App\Http\Controllers;

use App\Filters\ProjetoFilter;
use App\Http\Requests\CreateProjetoRequest;
use App\Http\Requests\UpdateProjetoRequest;
use App\Models\Projeto;
use App\Services\ProjetoService;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProjetoController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/projetos",
     *   operationId="getProjetosIndex",
     *   tags={"Projetos"},
     *   security={{"sanctum":{}}},
     *   summary="Exibe lista de projetos",
     *   description="",
     *   @OA\Parameter(name="id", description="Filtrar pelo ID", in="query", @OA\Schema(type="integer")),
     *   @OA\Parameter(name="nome", description="Filtrar pelo nome", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="cliente_nome", description="Filtrar pelo nome do cliente", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="uf", description="Filtrar pelo UF", in="query", @OA\Schema(type="string", enum={"SP", "MG"})),
     *   @OA\Parameter(name="instalacao_nome", description="Filtrar pelo nome da instalação", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="equipamento_nome", description="Filtrar pelo nome do equipamento", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="ordenar_id", description="Ordenar pelo ID", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Parameter(name="ordenar_nome", description="Ordenar pelo nome", in="query", @OA\Schema(type="string", enum={"asc", "desc"})),
     *   @OA\Response(
     *       response=200,
     *       description="OK",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Lista de projetos."),
     *           @OA\Property(property="content",type="object",
     *               @OA\Property(property="data", type="array",
     *                  @OA\Items(type="object", ref="#/components/schemas/ProjetoResource"),
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
    public function index(ProjetoFilter $filters, ProjetoService $projetoService): JsonResponse
    {
        try {
            $listProjetos = $projetoService->list($filters);

            if ($listProjetos['status'] === false) {
                return $this->badRequest(message: $listProjetos['message']);
            }

            return $this->success(
                message: $listProjetos['message'],
                content: $listProjetos['content']
            );
        } catch (\Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Post(
     *   path="/api/projetos",
     *   operationId="postProjetosStore",
     *   tags={"Projetos"},
     *   security={{"sanctum":{}}},
     *   summary="Cadastra novo projeto",
     *   description="",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/CreateProjetoRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Projeto cadastrado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/ProjetoResource"),
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
     *          @OA\Property(property="message",type="string",example="O campo cliente id selecionado é inválido."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="nome", type="array",
     *                   @OA\Items(type="string", example="O campo cliente id selecionado é inválido.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
    public function store(CreateProjetoRequest $createProjetoRequest, ProjetoService $projetoService): JsonResponse
    {
        try {
            $createProjeto = $projetoService->create($createProjetoRequest->validated());

            if ($createProjeto['status'] === false) {
                return $this->badRequest(message: $createProjeto['message']);
            }

            return $this->success(
                message: $createProjeto['message'],
                content: $createProjeto['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Get(
     *   path="/api/projetos/{id}",
     *   operationId="getProjetosShow",
     *   tags={"Projetos"},
     *   security={{"sanctum":{}}},
     *   summary="Pesquisa projeto pelo ID",
     *   description="",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID da projeto",
     *       example=1,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Projeto ID: 2"),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/ProjetoResource"),
     *        @OA\Property(property="code",type="integer",example="200"),
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad request."),
     *   @OA\Response(response=401, description="Unauthenticated."),
     *   @OA\Response(response=403, description="Forbidden."),
     *   @OA\Response(response=404, description="Not Found."),
     * )
     */
    public function show(Projeto $projeto, ProjetoService $projetoService)
    {
        try {
            $findProjeto = $projetoService->find($projeto);

            if ($findProjeto['status'] === false) {
                return $this->badRequest(message: $findProjeto['message']);
            }

            return $this->success(
                message: $findProjeto['message'],
                content: $findProjeto['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    /**
     * @OA\Put(
     *   path="/api/projetos/{id}",
     *   operationId="putProjetossUpdate",
     *   tags={"Projetos"},
     *   security={{"sanctum":{}}},
     *   summary="Atualiza os dados do projeto",
     *   description="Em equipamentos utilize:<br />
     *       acao = 'C' para adicionar um novo equipamento<br />
     *       acao = 'U' para atualizar um equipamento<br />
     *       acao = 'D' para excluir um equipamento",
     *   @OA\Parameter(
     *       name="id",
     *       description="ID do projeto",
     *       example=1,
     *       required=true,
     *       in="path",
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\RequestBody(required=true,
     *       @OA\JsonContent(ref="#/components/schemas/UpdateProjetoRequest"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *        @OA\Property(property="message",type="string",example="Projeto atualizado com sucesso."),
     *        @OA\Property(property="content",type="object", ref="#/components/schemas/ProjetoResource"),
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
     *          @OA\Property(property="message",type="string",example="O campo cliente id selecionado é inválido."),
     *          @OA\Property(property="errors",type="object",
     *               @OA\Property(property="email", type="array",
     *                   @OA\Items(type="string", example="O campo cliente id selecionado é inválido.")
     *               ),
     *          ),
     *       ),
     *   ),
     * )
     */
    public function update(Projeto $projeto, UpdateProjetoRequest $updateProjetoRequest, ProjetoService $projetoService)
    {
        try {
            $updateProjeto = $projetoService->update($projeto, $updateProjetoRequest->validated());

            if ($updateProjeto['status'] === false) {
                return $this->badRequest(message: $updateProjeto['message']);
            }

            return $this->success(
                message: $updateProjeto['message'],
                content: $updateProjeto['content']
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }
}
