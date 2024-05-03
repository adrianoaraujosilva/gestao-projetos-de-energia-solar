<?php

namespace App\Services;

use App\Filters\ProjetoFilter;
use App\Http\Resources\ProjetoResource;
use App\Models\Equipamento;
use App\Models\Projeto;
use App\Traits\ServiceResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProjetoService
{
    use ServiceResponse;

    public function list(ProjetoFilter $filters): array
    {
        return $this->response(
            message: 'Lista de projetos.',
            content: Projeto::with([
                'cliente',
                'cliente.integrador',
                'instalacao',
                'equipamentos',
            ])->filter($filters)
                ->paginate()
        );
    }

    public function create(array $request): array
    {
        try {
            DB::beginTransaction();
            $createProjeto = Projeto::create($request);
            $createProjeto->equipamentos()->attach($request['equipamentos']);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return $this->response(status: false, message: "Ocorreu um erro ao tentar inserir o projeto, informe o administrador do sistema!");
        }


        return $this->response(
            message: 'Projeto cadastradp com sucesso.',
            content: new ProjetoResource($createProjeto)
        );
    }

    public function find(Projeto $projeto): array
    {
        return $this->response(
            message: "projeto ID: {$projeto->id}",
            content: new ProjetoResource($projeto)
        );
    }

    public function update(Projeto $projeto, array $request): array
    {
        try {
            DB::beginTransaction();
            // Atualiza dados do projeto
            $updateProjeto = tap($projeto)->update($request);
            // Armazena todos os equipamentos do projeto na variável
            $equipamentos = $projeto->equipamentos;

            // Itera todos os equipamentos enviados na requisição
            // e monta uma Array com registros para sincronizar
            $syncData = [];
            $deleteData = [];
            foreach ($request['equipamentos'] ?? [] as $equipamento) {
                switch ($equipamento["acao"]) {
                    case 'C': // Cadastro, adiciona na Array
                        $syncData[$equipamento["equipamento_id"]] = $this->addSyncItem(equipamento: $equipamento);
                        break;
                    case 'U': // Atualização, adiciona na Array com os valores que foram modificados
                        // Recupera valores armazenado para o equipamento em edição
                        $syncData[$equipamento["equipamento_id"]] = $this->addSyncItem(
                            equipamento: $equipamento,
                            equipamentoAux: $equipamentos->where("id", $equipamento["equipamento_id"])->first()
                        );
                        break;
                    default:
                        break;
                }
                // Adiciona o id do equipamento para excluir durante a sincronização
                // em qualquer operação, uma vez que o cadatro e atualização já estão incluidos na Array syncData
                array_push($deleteData, $equipamento["equipamento_id"]);
            }

            // Itera equipamentos cadastrados originalmente, removendo os itens que
            // estão na Array deleteData para adicionar os equipamentos que não sofreram alteração
            $equipamentosOriginal = [];
            foreach ($equipamentos->whereNotIn("id", $deleteData) as $equipamento) {
                $equipamentosOriginal[$equipamento["pivot"]["equipamento_id"]] = [
                    "quantidade"        => $equipamento["pivot"]["quantidade"],
                    "descricao"         => $equipamento["pivot"]["descricao"],
                ];
            }

            // Sincroniza equipamentos com os itens Criados, Atualizados, Removidos
            // e mantendo os originais que não sofreram alterações
            $updateProjeto->equipamentos()->sync($equipamentosOriginal + $syncData);
            DB::commit();

            return $this->response(
                message: 'Projeto atualizado com sucesso.',
                content: new ProjetoResource($updateProjeto->load("equipamentos"))
            );
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return $this->response(status: false, message: "Ocorreu um erro ao tentar atualizar o projeto, informe o administrador do sistema!");
        }
    }

    private function addSyncItem(array $equipamento, Equipamento $equipamentoAux = null): array
    {
        return [
            "quantidade"        => $equipamento["quantidade"] ?? $equipamentoAux->pivot->quantidade,
            "descricao"         => $equipamento["descricao"] ?? $equipamentoAux->pivot->descricao ?? null,
        ];
    }
}
